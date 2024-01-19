let _httpHost = null;

export function setHttpHost(httpHost) {
    _httpHost = httpHost;
}

/* ======================= PASSWORD TOOL FUNCTIONS ======================= */

export function generatePassword(buttonElement, elements) {

    let errorMessageElement = elements['errorMessageElement'];
    let passwordLengthElement = elements['passwordLengthElement'];
    let passwordCountElement = elements['passwordCountElement'];
    let passwordCharacterSet1Element = elements['passwordCharacterSet1Element'];
    let passwordCharacterSet2Element = elements['passwordCharacterSet2Element'];
    let passwordCharacterSet3Element = elements['passwordCharacterSet3Element'];
    let passwordCharacterSet4Element = elements['passwordCharacterSet4Element'];
    let passwordCharacterSet5Element = elements['passwordCharacterSet5Element'];
    let generatedPasswordsElement = elements['generatedPasswordsElement'];
    let goToTOpButtonElement = elements['goToTOpButtonElement'];

    let passwordLengthStr = passwordLengthElement.value.toString().trim();
    let passwordLengthStrLength = passwordLengthStr.length;
    if (passwordLengthStrLength == 0) {

        errorMessageElement.innerText = 'Password length is missing'

    } else {

        generatedPasswordsElement.innerHTML = '';

        /* PASSWORD LENGTH */
        let invalidCharacter = getInvalidCharacters(passwordLengthStr, '0123456789');
        if (invalidCharacter != '') {
            errorMessageElement.innerText = 'Password length contains invalid character: [' + invalidCharacter + ']'

        } else {

            let passwordLength = parseInt(passwordLengthStr);
            if (passwordLength < 6) {
                errorMessageElement.innerText = 'Password length must be >= 6'

            } else if (passwordLength > 2048) {
                errorMessageElement.innerText = 'Come on, nobody needs a password that long!';

            } else {

                /* PASSWORD COUNT */

                let passwordCountStr = passwordCountElement.value.toString().trim();
                let passwordCountStrLength = passwordCountStr.length;
                if (passwordCountStrLength == 0) {
                    errorMessageElement.innerText = 'Number of passwords is missing'

                } else {

                    let invalidCharacter = getInvalidCharacters(passwordCountStr, '0123456789');
                    if (invalidCharacter != '') {
                        errorMessageElement.innerText = 'Number of passwords contains invalid character: [' + invalidCharacter + ']'

                    } else {

                        let passwordCount = parseInt(passwordCountStr);
                        if (passwordCount < 1) {
                            errorMessageElement.innerText = 'Number of passwords must be >= 1'

                        } else if (passwordCount > 50) {
                            errorMessageElement.innerText = 'Number of passwords must be <= 50';

                        } else {

                            /* PASSWORD CHARACTER SETS */

                            if (!passwordCharacterSet1Element.checked &&
                                !passwordCharacterSet2Element.checked &&
                                !passwordCharacterSet3Element.checked &&
                                !passwordCharacterSet4Element.checked &&
                                !passwordCharacterSet5Element.checked) {

                                errorMessageElement.innerText = 'You must include at least 1 of the 5 character-sets';

                            } else {

                                errorMessageElement.innerText = '';

                                let passwordCharacters = '';
                                if (passwordCharacterSet1Element.checked) {
                                    passwordCharacters += passwordCharacterSet1Element.value;
                                }
                                if (passwordCharacterSet2Element.checked) {
                                    passwordCharacters += passwordCharacterSet2Element.value;
                                }
                                if (passwordCharacterSet3Element.checked) {
                                    passwordCharacters += passwordCharacterSet3Element.value;
                                }
                                if (passwordCharacterSet4Element.checked) {
                                    passwordCharacters += passwordCharacterSet4Element.value;
                                }
                                if (passwordCharacterSet5Element.checked) {
                                    passwordCharacters += passwordCharacterSet5Element.value;
                                }

                                let data = {
                                    passwordLength: passwordLength,
                                    passwordCount: passwordCount,
                                    passwordCharacters: passwordCharacters
                                }

                                let xhr = new XMLHttpRequest();
                                xhr.open("POST",  _httpHost + '/ToolsController/jsGeneratePasswords', true);
                                xhr.setRequestHeader('Content-Type', 'application/json');
                                xhr.send(JSON.stringify({
                                    'data': data
                                }));
                                xhr.onload = function(responseData) {

                                    let returnData = JSON.parse(responseData.target.response);

                                    if (returnData !== null && returnData !== undefined && returnData.passwords !== null && returnData.passwords !== undefined) {

                                        let passwordsCount = returnData.passwords.length;
                                        for (let i = 0; i < passwordsCount; i++) {

                                            let trNode = document.createElement('tr');
                                            let thNode = document.createElement('th');

                                            let spanNode= document.createElement('span');
                                            spanNode.setAttribute('class', 'tag is-medium');
                                            spanNode.innerText = '#' + (i + 1);

                                            thNode.appendChild(spanNode);
                                            trNode.appendChild(thNode);

                                            let inputNode = document.createElement('input');
                                            inputNode.setAttribute('readonly', '');
                                            inputNode.setAttribute('id', 'password' + i);
                                            inputNode.setAttribute('type', 'text');
                                            inputNode.setAttribute('class', 'input ');
                                            inputNode.setAttribute('value', returnData.passwords[i]);

                                            let tdNode = document.createElement('td');
                                            tdNode.appendChild(inputNode);
                                            trNode.appendChild(tdNode);

                                            tdNode = document.createElement('td');

                                            let buttonNode = document.createElement('button');
                                            buttonNode.innerText = 'Copy #' + (i + 1);
                                            buttonNode.setAttribute('onclick', "navigator.clipboard.writeText('" + returnData.passwords[i] + "');");
                                            buttonNode.setAttribute('class', 'button is-dark');
                                            tdNode.appendChild(buttonNode);
                                            trNode.appendChild(tdNode);

                                            generatedPasswordsElement.appendChild(trNode);
                                            goToTOpButtonElement.setAttribute('class', 'button is-dark');

                                            document.location.href = '#generatedPasswords';
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    }

    if (errorMessageElement.innerText.length == 0) {
        errorMessageElement.removeAttribute('class');
    } else {
        errorMessageElement.setAttribute('class', 'notification is-danger');
        goToTOpButtonElement.setAttribute('class', 'button is-dark hideElement');
    }
}


/* ======================= SPINTEXT TOOL FUNCTIONS ======================= */


export function generateFiles(buttonElement, elements) {

    let buttonId = buttonElement.getAttribute('id');
    let filesFormat = 'txt'
    if (buttonId == 'generateCsvFilesButton') {
        filesFormat = 'csv';
    } else if (buttonId == 'generateTextFilesButton') {
        filesFormat = 'txt';
    }

    let errorMessageElement = elements['errorMessageElement'];
    let spintaxElement = elements['spintaxElement'];
    let spinTextElement = elements['spinTextElement'];
    let coloredSpintaxElement = elements['coloredSpintaxElement'];
    let filesCountElement = elements['filesCountElement'];
    let downloadLinksElement = elements['downloadLinksElement'];

    spinTextElement.innerText = '';
    coloredSpintaxElement.innerHTML = '';

    let spintaxElementStr = spintaxElement.value.toString().trim();
    if (spintaxElementStr.length == 0) {

        errorMessageElement.setAttribute('class', 'red')
        errorMessageElement.innerText = 'Spintax is missing'

    } else {

        /* VALIDATE SPINTAX */

        let data = {
            spintax: spintaxElementStr,
        }

        let xhr = new XMLHttpRequest();
        xhr.open("POST",  _httpHost + '/ToolsController/jsSpinValidateSpintax', true);
        xhr.setRequestHeader('Content-Type', 'application/json');
        xhr.send(JSON.stringify({
            'data': data
        }));
        xhr.onload = function(responseData) {

            let returnData = JSON.parse(responseData.target.response);

            if (returnData !== null && returnData !== undefined && returnData.errorMessage !== null && returnData.errorMessage !== undefined) {

                if (returnData.errorMessage.length > 0) {

                    errorMessageElement.setAttribute('class', 'red')
                    errorMessageElement.innerText = returnData.errorMessage;

                } else {

                    /* CONVERT SPINTAX TO TEXT IN SEVERAL FILES */

                    data = {
                        filesFormat: filesFormat,
                        filesCount: filesCountElement.value,
                        spintax: spintaxElementStr,
                    }

                    errorMessageElement.setAttribute('class', 'green')
                    errorMessageElement.innerText = 'Generating zip file - please wait...';

                    let xhr = new XMLHttpRequest();
                    xhr.open("POST", _httpHost + '/ToolsController/jsSpinGenerateFiles', true);
                    xhr.setRequestHeader('Content-Type', 'application/json');
                    xhr.send(JSON.stringify({
                        'data': data
                    }));
                    xhr.onload = function (responseData) {

                        let returnData = JSON.parse(responseData.target.response);

                        if (returnData !== null && returnData !== undefined && returnData.statusMessage !== null && returnData.statusMessage !== undefined && returnData.zipFileRelativePath !== null && returnData.zipFileRelativePath !== undefined) {

                            let downloadLink = document.createElement('a');
                            // encodeURIComponent()
                            // downloadLink.setAttribute('href', 'data:application/zip,download-that-spintax.zip');
                            downloadLink.setAttribute('href', '/download/' + returnData.zipFileRelativePath);
                            downloadLink.setAttribute('download', '');
                            downloadLink.style.display = 'none';
                            downloadLinksElement.appendChild(downloadLink);
                            downloadLink.click();
                            downloadLinksElement.removeChild(downloadLink);

                            errorMessageElement.removeAttribute('class')
                            errorMessageElement.innerText = '';
                        }
                    }
                }
            }
        }
    }

}

export function generateSpinText(buttonElement, elements) {

    let errorMessageElement = elements['errorMessageElement'];
    let spintaxElement = elements['spintaxElement'];
    let spinTextElement = elements['spinTextElement'];
    let coloredSpintaxElement = elements['coloredSpintaxElement'];

    spinTextElement.innerText = '';
    coloredSpintaxElement.innerHTML = '';
    errorMessageElement.removeAttribute('class');

    let spintaxElementStr = spintaxElement.value.toString().trim();
    if (spintaxElementStr.length == 0) {

        errorMessageElement.setAttribute('class', 'red')
        errorMessageElement.innerText = 'Spintax is missing'

    } else {


        /* VALIDATE SPINTAX */

        let data = {
            spintax: spintaxElementStr,
        }

        let xhr = new XMLHttpRequest();
        xhr.open("POST",  _httpHost + '/ToolsController/jsSpinValidateSpintax', true);
        xhr.setRequestHeader('Content-Type', 'application/json');
        xhr.send(JSON.stringify({
            'data': data
        }));
        xhr.onload = function(responseData) {

            let returnData = JSON.parse(responseData.target.response);

            if (returnData !== null && returnData !== undefined && returnData.errorMessage !== null && returnData.errorMessage !== undefined) {

                let errorMessage = returnData.errorMessage;

                if (errorMessage.length == 0) {
                    errorMessageElement.setAttribute('class', 'green')
                    errorMessageElement.innerText = 'Spintax is valid';

                } else {

                    errorMessageElement.setAttribute('class', 'red')
                    errorMessageElement.innerText = errorMessage;
                }

                /* CONVERT SPINTAX TO TEXT */

                let xhr = new XMLHttpRequest();
                xhr.open("POST", _httpHost + '/ToolsController/jsSpinSpinTax', true);
                xhr.setRequestHeader('Content-Type', 'application/json');
                xhr.send(JSON.stringify({
                    'data': data
                }));
                xhr.onload = function (responseData) {

                    let returnData = JSON.parse(responseData.target.response);

                    if (returnData !== null && returnData !== undefined && returnData.spinText !== null && returnData.spinText !== undefined) {
                        spinTextElement.innerText = returnData.spinText;

                        if (returnData.spinText.length > 0) {

                            /* GET COLORED SPINTAX */

                            let xhr = new XMLHttpRequest();
                            xhr.open("POST", _httpHost + '/ToolsController/jsSpinColorSpinTax', true);
                            xhr.setRequestHeader('Content-Type', 'application/json');
                            xhr.send(JSON.stringify({
                                'data': data
                            }));
                            xhr.onload = function (responseData) {

                                let returnData = JSON.parse(responseData.target.response);

                                if (returnData !== null && returnData !== undefined && returnData.coloredSpinTax !== null && returnData.coloredSpinTax !== undefined) {
                                    coloredSpintaxElement.innerHTML = returnData.coloredSpinTax;
                                }
                            }
                        }
                    }
                }
            }
        }
    }
}

/* ======================= TRANSFER TOOL FUNCTIONS ======================= */
export function handleTransferUpload(event, elements, fileExtensionsAllowedJson) {

    let uploadButtonElement = elements['uploadButtonElement'];
    let uploadStatusProgressElement = elements['uploadStatusProgressElement'];
    let uploadStatusProgress2Element = elements['uploadStatusProgress2Element'];
    let uploadStatusElement = elements['uploadStatusElement'];
    let chooseFileLabelElement = elements['chooseFileLabelElement'];
    let fileNameElement = elements['fileNameElement'];
    let transferUploadFormElement = elements['transferUploadFormElement'];
    let uploadErrorMessageElement = elements['uploadErrorMessageElement'];
    let uploadFileResultElement = elements['uploadFileResultElement'];
    let uploadFileLinkElement = elements['uploadFileLinkElement'];

    let fileExtensionsAllowed = JSON.parse(fileExtensionsAllowedJson);
    uploadFileResultElement.style.visibility = 'hidden';

    /*
    const form = event.currentTarget;
    const formData = new FormData(form);
    const request = new Request(form.action, {
        method: 'POST',
        body: formData
    });

    fetch(request)
        .then(response => response.json())
        .then(data => {
            uploadStatusElement.innerText = data['statusMessage'];
        });
    */

    let inputFileName = document.querySelector('#file').files[0];
    if (inputFileName !== null && inputFileName !== undefined && inputFileName['name'] !== null && inputFileName['name'] !== undefined && inputFileName['name'].length > 0) {

        let inputFileNameElements = inputFileName['name'].split('.');
        if (inputFileNameElements.length > 1) {

            let fileExtention = inputFileNameElements.pop().toString().toLowerCase();
            if (fileExtensionsAllowed.indexOf(fileExtention) >= 0) {

                // Tjekke om file-extension er tilladt
                let inputFileSizeInMb = inputFileName.size / 1024 / 1024;
                if (inputFileSizeInMb <= 1000.0) {

                    uploadErrorMessageElement.innerText = '';
                    chooseFileLabelElement.style.visibility = 'hidden';
                    uploadButtonElement.style.visibility = 'hidden';
                    uploadStatusElement.style.visibility = 'visible';

                    let data = new FormData();
                    data.append('file', inputFileName);

                    let request = new XMLHttpRequest();
                    request.open('POST', '/transfer-upload');

                    // Upload progress event
                    request.upload.addEventListener('progress', function (e) {

                        // Upload progress as percentage
                        let percent_completed = (e.loaded / e.total) * 100;
                        uploadStatusProgressElement.style.width = (percent_completed * 2) + 'px';

                        if (percent_completed < 100) {
                            uploadStatusProgress2Element.innerText = 'Uploading file..';
                        } else {
                            uploadStatusProgress2Element.innerText = 'Handle file...';
                        }

                    });

                    // Request finished event
                    request.addEventListener('load', function (e) {

                        // HTTP status message (200, 404 etc)
                        // Request.status
                        uploadStatusProgressElement.style.width = '206px';
                        uploadStatusProgress2Element.innerText = 'Upload done!';

                        setTimeout(() => {

                            uploadStatusProgress2Element.innerText = '';
                            uploadStatusProgressElement.style.width = '0px';
                            uploadStatusElement.style.visibility = 'hidden';
                            // uploadButtonElement.style.visibility = 'visible';
                            // chooseFileLabelElement.style.visibility = 'visible';
                            transferUploadFormElement.reset();
                            fileNameElement.textContent = 'No file selected';

                            // request.response holds response from the server
                            if (request.response !== null && request.response !== undefined && request.response.toString().length > 0) {

                                let responseData = JSON.parse(request.response);

                                if (responseData['errorMessage'] !== null && responseData['errorMessage'] !== undefined && responseData['errorMessage'].toString().length > 0) {
                                    uploadErrorMessageElement.innerText = responseData['errorMessage'];
                                } else if (responseData['statusMessage'] !== null && responseData['statusMessage'] !== undefined && responseData['statusMessage'].toString().length > 0) {
                                    uploadFileResultElement.style.visibility = 'visible';
                                    uploadFileLinkElement.value = _httpHost + '/download/' + responseData['statusMessage'];
                                }

                            } else {
                                uploadErrorMessageElement.innerText = 'File was not uploaded, please try again';
                            }

                        }, 600);
                    });

                    // send POST request to server
                    request.send(data);
                } else {
                    uploadErrorMessageElement.innerText = 'File is to big';
                }
            } else {
                uploadErrorMessageElement.innerText = 'File extension [' + fileExtention + '] is not allowed';
            }
        } else {
            uploadErrorMessageElement.innerText = 'Cannot read file-extension from selected file';
        }
    } else {
        uploadErrorMessageElement.innerText = 'Please select af file';
    }
}



export function copyDownloadLinkToClipBoard(event, elements) {
    let uploadFileLinkElement = elements['uploadFileLinkElement'];
    navigator.clipboard.writeText(uploadFileLinkElement.value);
}

export function sendLinkInEmail(event, elements) {

    let uploadFileResultElement = elements['uploadFileResultElement'];
    let uploadFileLinkElement = elements['uploadFileLinkElement'];

    let aTag = document.createElement('a');
    aTag.style.visibility = 'hidden';
    aTag.setAttribute('href', 'mailto:?subject=' + encodeURIComponent('Download file: ' + uploadFileLinkElement.value) + '&body=' + encodeURIComponent('Download file: ' + uploadFileLinkElement.value));
    uploadFileResultElement.append(aTag);
    aTag.click();
    aTag.remove();
}

/* ======================= GENERAL FUNCTIONS ======================= */

function getInvalidCharacters(data, validCharacters) {

    let illegalCharacter = '';

    if (data !== null && data !== undefined && validCharacters !== null && validCharacters !== undefined) {

        data = data.toString().trim();
        validCharacters = validCharacters.toString().trim();
        if (data.length > 0 && validCharacters.length > 0) {

            let dataElements = data.split('');
            let dataElementsCount = dataElements.length;
            for (let i = 0; i < dataElementsCount; i++) {
                let dataElement = dataElements[i];

                if (validCharacters.indexOf(dataElement) == -1) {
                    illegalCharacter = dataElement;
                    break;
                }
            }
        }
    }

    return illegalCharacter;

}