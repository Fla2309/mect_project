defData=[];

function saveSettings(){
    data = $('form#settingsForm div.input-group > input[id]');
    console.log(data);
    window.location = '/index.php';
}

function getSettings(){
    defData = $('form#settingsForm div.input-group > input[id]').each(function(){this.value.toString()});
}

function discardSettings(){
    data = $('form#settingsForm div.input-group > input[id]');
    data.each(function(){
    });
    //window.location = '/index.php';
    for (let index = 0; index < data.length; index++) {
        console.log(defData[index].value);
        console.log(data[index]['value']);
    }
}