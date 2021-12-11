function codeGenerate(){
    let result           = '';
    let characters       = 'abcdefghijklmnopqrstuvwxyz0123456789';
    let charactersLength = characters.length;
    for ( let i = 0; i < 25; i++ ) {
        result += characters.charAt(Math.floor(Math.random() * charactersLength));
    }
    return result;
}

function setCodeGenerate(inputField){
    let code = codeGenerate()
    $('#' + inputField).val(code);

}