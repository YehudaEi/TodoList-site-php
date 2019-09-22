/*! Todo list | https://yehudae.ga | (c) 2019 Yehuda Eisenberg | MIT License */

var AllData;
var OldAllData;
var API_URL = "?api&method=";
var TempMatala;

$(() => init());

function init(){
    document.getElementById('matalaTitle').value = "";
    document.getElementById('matalaDescription').value = "";
    document.getElementById('tagit-1').value = "";
    document.getElementById('tagit-1-select').value = "";
    document.getElementById('tagit-2').value = "";
    document.getElementById('tagit-2-select').value = "";
    document.getElementById('tagit-3').value = "";
    document.getElementById('tagit-3-select').value = "";
    
    makeRequest('Get').then(data => {
        //console.log(data);
        AllData = data;
        OldAllData = data;
        buildMatalot();
    });
}

function SaveMatalot() {
    let TempData = {
        'todo': [],
        'doing': [],
        'done': [],
        'count': AllData.count
    };

    ['todo', 'doing', 'done'].forEach((key) => {
        $('#' + key + ' > div').each(function () {
            //console.log($(this).data('matalaid'));

            let id = $(this).data('matalaid');

            var matala = findMatla(id);
            matala.type = key;
            TempData[key].push(matala);
        });
    });
    
    makeRequest('Save', {'Data': JSON.stringify(TempData)});
}

function getTagitClass(type) {
    if (type == '1') {
        return 'uk-label-success'
    } else if (type == '2') {
        return 'uk-label-warning'
    } else if (type == '3') {
        return 'uk-label-danger'
    } else if (type == '4') {
        return ''

    }
}

function buildMatalot() {
    buildMatala('todo');
    buildMatala('doing');
    buildMatala('done');
}

function buildMatala(name) {
    text = '';
    AllData[name].forEach(element => {
        text +=
            '<div class="uk-margin" data-matalaid="' + element.id +
            '"><div class="uk-card uk-card-default uk-card-body uk-card-small uk-text-center" style="padding-top:7px !important;">';

        if (element.tagiot.length > 0) {
            text += '<div class="label-containter uk-text-left">';
            element.tagiot.forEach(tagit => {
                text += '<span class="uk-margin-small-left uk-label ' + getTagitClass(
                        tagit
                        .type) + '">' + tagit
                    .name + '</span>';

            });
            text += '</div>';

        }
        text += '<ul uk-accordion="toggle: > .uk-accordion-title" class="">';
        text += '<li>';
        text += '<a class="uk-accordion-title uk-text-bold" href="#">' + element.title + '</a>';
        text += '<div class="uk-accordion-content">';
        text += '<p>' + element.pirot + '</p>';
        text += '<p class="uk-text-small uk-text-left">' + new Date(element.date)
            .toLocaleString() + '<a href="#" uk-icon="icon: trash" onclick="deleteMatala('+element.id+')"></a>' +
            '</p>';
            
        text += '</div></li></ul></div></div>';
    });

    $('#' + name).html(text);
}

function addMatala() {
    SaveMatalot();
    
    let title = document.getElementById('matalaTitle').value;
    let pirot = document.getElementById('matalaDescription').value;
    let tagit1 = document.getElementById('tagit-1').value;
    let tagit1type = document.getElementById('tagit-1-select').value;
    let tagit2 = document.getElementById('tagit-2').value;
    let tagit2type = document.getElementById('tagit-2-select').value;
    let tagit3 = document.getElementById('tagit-3').value;
    let tagit3type = document.getElementById('tagit-3-select').value;

    if(title == "" || title == undefined){
        alert("הכותרת ריקה");
        return;
    }
    if(pirot == "" || pirot == undefined){
        alert("התיאור ריק");
        return;
    }

    let tagiot = [];

    if (tagit1 != '') {
        tagiot.push({
            'name': tagit1,
            'type': tagit1type
        });
    }
    if (tagit2 != '') {
        tagiot.push({
            'name': tagit2,
            'type': tagit2type
        });
    }
    if (tagit3 != '') {
        tagiot.push({
            'name': tagit3,
            'type': tagit3type
        });
    }

    matala = {
        'type': 'todo',
        'title': title,
        'pirot': pirot,
        'tagiot': tagiot,
    };

    makeRequest('Add', {
        'matala': JSON.stringify(matala)
    }).then(data => {
        if (data.ok) {
            UIkit.notification({
                message: "<span uk-icon='icon: check'></span> המטלה נוספה",
                pos: 'top-right'
            });
            init();
        }
    });
}

function deleteMatala(id){
    SaveMatalot();
    
    makeRequest('Delete', {
        'id': id
    }).then(data => {
        if (data.ok) {
            UIkit.notification({
                message: "<span uk-icon='icon: check'></span> המטלה נמחקה",
                pos: 'top-right'
            });
            init();
        }
    });
}

function findMatla(id) {
    let a = ['todo', 'doing', 'done'];

    for (let index = 0; index < a.length; index++) {
        const key = a[index];
        t = findWithAttr(AllData[key], 'id', id);

        if (t != null) {
            return t;
        }
    }
}

function findWithAttr(array, attr, value) {
	for (var i = 0; i < array.length; i += 1) {
		if (array[i][attr] == value) {
			return array[i];
		}
	}
	return null;
}

function makeRequest(method, params = '') {
    return $.ajax({
        type: "post",
        url: API_URL + method,
        data: params,
        dataType: "json",
    });
}


window.onbeforeunload = function(){
    setTimeout(SaveMatalot, 0);
    return;
};




