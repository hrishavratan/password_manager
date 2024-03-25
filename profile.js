let generatedPassword = "";

document.getElementById('generateBtn').addEventListener("click", generateRandomPassword);

function generateRandomPassword()
{

    const passwordLength = document.getElementById('passwordLength').value;
    const includeSpecialCharsCheckbox = document.getElementById('includeSpecialChars');
    var p = document.getElementById('password');
    password = "";

    var charset = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";

    if (includeSpecialCharsCheckbox.checked) 
    {
        const specialChars = "!@#$%^&*()_-+=<>?";
        charset += specialChars;
    }

    for (let i = 0; i < passwordLength; i++) {
        const randomIndex = Math.floor(Math.random() * charset.length);
        password += charset[randomIndex];
    }
    generatedPassword = password;
    p.innerHTML = generatedPassword;
}


