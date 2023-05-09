let _httpHost = null;

export function setHttpHost(httpHost) {
    _httpHost = httpHost;
}

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