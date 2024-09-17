
        const openModalButton = document.getElementById('openModalButton');
        const modal = document.getElementById('pictureModal');
        const pictureOptions = document.querySelectorAll('.picture-option');
        const submitButton = document.getElementById('submitSelection');

        openModalButton.onclick = function() {
            modal.style.display = 'block';
        }
        pictureOptions.forEach(option => { // toto jsem si nechal pomoct protoze by jsem na to sam neprisel 
            option.onclick = function() {
                pictureOptions.forEach(opt => opt.classList.remove('selected'));
                this.classList.add('selected');
            }
        });
        submitButton.onclick = function() {
            const selectedPicture = document.querySelector('.picture-option.selected');
            if (!selectedPicture) {
                alert('Please select a picture.');
            }
        }
        function selectPicture(picId) { // toto jsem si nechal pomoct protoze by jsem na to sam neprisel 
            document.querySelectorAll('.picture-option img').forEach(img => {img.classList.remove('selected');
            });
            document.getElementById(picId).classList.add('selected');
            document.getElementById(picId).previousElementSibling.value = picId;
        }

        
