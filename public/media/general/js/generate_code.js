function codeGenerate(){
    let chars = 'abcdefghijklmnopqrstuvwxyz';
    let nums = '0123456789';
    let php = "iLovePHP-";
    let result = '';
    for (let i = 1; i < 10; i++) {
        if (i%3 === 0) {
            result += nums.charAt(Math.floor(Math.random() * nums.length));
        }else {
            result += chars.charAt(Math.floor(Math.random() * chars.length));
        }
    }
    return php + result;
}

function setCodeGenerate(inputField){
    let code = codeGenerate()
    $('#' + inputField).val(code);
}