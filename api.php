<?php
include_once 'source/DBC.php';
session_start();
$loggedInUser = isset($_SESSION["username"]) ? $_SESSION["username"] : null;
$requestMethod = $_SERVER["REQUEST_METHOD"];
$server_URI = strtok($_SERVER['REQUEST_URI'], '?');
$response = array();

switch ($requestMethod) {
    case 'GET':
        if (isset($_GET['id'])) {
            $blogId = intval($_GET['id']);
            $post = DBC::getBlogPost($blogId);
            if ($post) {
                if ($post['author'] === $loggedInUser || $post['visibility'] === 'public') {
                    $response = $post;
                    http_response_code(200);
                } else {
                    http_response_code(403);
                    $response = [
                        'status' => 403,
                        'message' => 'You do not have permission to view this post'
                    ];
                }
            } else {
                http_response_code(404);
                $response = [
                    'status' => 404,
                    'message' => 'Blog post not found'
                ];
            }
        } else if ($server_URI == '/api/about') {
            $response = [
                'status' => 200,
                'message' => 'API Documentation',
                'endpoints' => [
                    [
                        'method' => 'GET',
                        'endpoint' => '/api/blog',
                        'description' => 'Retrieve all blog posts or posts.',
                        'response_format' => 'JSON array of blog posts',
                    ],
                    [
                        'method' => 'GET',
                        'endpoint' => '/api/blog/{id}',
                        'description' => 'Retrieve a single blog post by ID.',
                        'response_format' => 'JSON object of the blog post',
                    ],
                    [
                        'method' => 'POST',
                        'endpoint' => '/api/blog',
                        'description' => 'Create a new blog post.',
                        'request_format' => 'JSON object with fields: content, author, visibility',
                        'response_format' => 'JSON object with status and ID of created post',
                    ],
                    [
                        'method' => 'DELETE',
                        'endpoint' => '/api/blog/{id}',
                        'description' => 'Delete a blog post by ID.',
                        'response_format' => 'JSON object with status message',
                    ],
                    [
                        'method' => 'PATCH',
                        'endpoint' => '/api/blog/{id}',
                        'description' => 'Update an existing blog post by ID.',
                        'request_format' => 'JSON object with fields to update',
                        'response_format' => 'JSON object with status message',
                    ],
                    [
                        'method' => 'GET',
                        'endpoint' => '/api/about',
                        'description' => 'Display API documentation.',
                        'response_format' => 'JSON object with API information',
                    ],
                ],
                'authorization' => [
                    'description' => 'Users must be logged in to create, update, or delete blog posts. Authorization is handled via session management; a valid session must exist to perform these actions.',
                    'admin_access' => 'Admins can manage all posts and see every post, while regular users can only manage their own posts and see only their own posts or public posts.',
                ],
            ];
            http_response_code(200);
        } else {
            $result = DBC::getBlogPosts($loggedInUser);
            if ($result) {
                header("Content-Type: application/json");
                while ($row = mysqli_fetch_assoc($result)) {
                    $response[] = $row;
                }
                http_response_code(200);
            } else {
                http_response_code(500);
                $response = [
                    'status' => 500,
                    'message' => 'Failed to retrieve blog posts'
                ];
            }
        }
        echo json_encode($response, JSON_PRETTY_PRINT);
        break;

    case 'POST':
        $input = json_decode(file_get_contents('php://input'), true);
        if (isset($input['content']) && $loggedInUser != NULL) {
            $content = $input['content'];
            $author = $loggedInUser;
            $visibility = isset($input['visibility']) ? $input['visibility'] : 'public';
            $insertId = DBC::insertBlogPost($content, $author, $visibility);
            if ($insertId) {
                http_response_code(201);
                $response = [
                    'status' => 201,
                    'message' => 'Blog post created',
                    'id' => $insertId
                ];
            } else {
                http_response_code(500);
                $response = [
                    'status' => 500,
                    'message' => 'Failed to create blog post'
                ];
            }
        }else if($loggedInUser == NULL){
            http_response_code(500);
                $response = [
                    'status' => 500,
                    'message' => 'Failed to create blog post, not logged in'
                ];
        } else {
            http_response_code(400);
            $response = [
                'status' => 400,
                'message' => 'Invalid input'
            ];
        }
        echo json_encode($response);
        break;

    case 'DELETE':
        if (isset($_GET['id'])) {
            $blogId = intval($_GET['id']);
            $post = DBC::getBlogPost($blogId);
            if ($post) {
                if ($post['author'] === $loggedInUser || DBC::isAdmin($loggedInUser)) {
                    $deleteResult = DBC::deleteBlogPost($blogId);
                    if ($deleteResult) {
                        http_response_code(200);
                        $response = [
                            'status' => 200,
                            'message' => 'Blog post deleted'
                        ];
                    } else {
                        http_response_code(404);
                        $response = [
                            'status' => 404,
                            'message' => 'Blog post not found'
                        ];
                    }
                } else {
                    http_response_code(403);
                    $response = [
                        'status' => 403,
                        'message' => 'You do not have permission to delete this post'
                    ];
                }
            } else {
                http_response_code(404);
                $response = [
                    'status' => 404,
                    'message' => 'Blog post not found'
                ];
            }
        } else {
            http_response_code(400);
            $response = [
                'status' => 400,
                'message' => 'Blog post ID required'
            ];
        }
        echo json_encode($response);
        break;

    case 'PATCH':
        if (isset($_GET['id'])) {
            $blogId = intval($_GET['id']);
            $post = DBC::getBlogPost($blogId);
            if ($post) {
                if ($post['author'] === $loggedInUser || DBC::isAdmin($loggedInUser)) {
                    $input = json_decode(file_get_contents('php://input'), true);
                    $updateResult = DBC::updateBlogPost($blogId, $input);
                    if ($updateResult) {
                        http_response_code(200);
                        $response = [
                            'status' => 200,
                            'message' => 'Blog post updated'
                        ];
                    } else {
                        http_response_code(404);
                        $response = [
                            'status' => 404,
                            'message' => 'Blog post not found'
                        ];
                    }
                } else {
                    http_response_code(403);
                    $response = [
                        'status' => 403,
                        'message' => 'You do not have permission to update this post'
                    ];
                }
            } else {
                http_response_code(404);
                $response = [
                    'status' => 404,
                    'message' => 'Blog post not found'
                ];
            }
        } else {
            http_response_code(400);
            $response = [
                'status' => 400,
                'message' => 'Blog post ID required'
            ];
        }
        echo json_encode($response);
        break;

    default:
        http_response_code(405);
        $response = [
            'status' => 405,
            'message' => $requestMethod . ' Method Not Allowed'
        ];
        echo json_encode($response);
        break;
}
?>
