/*! Todo list | https://yehudae.ga | (c) 2019 Yehuda Eisenberg | MIT License */ 

var AllData;
var API_URL = "?api&method=";
var TempMatala;
$(() => init(true));

function init(bool) {
    document.getElementById('addMatalaTitle').innerText = "הוספת מטלה";
    document.getElementById('addMatalaButton').innerText = "הוסף";
    document.getElementById('matalaTitle').value = "";
    document.getElementById('matalaDescription').value = "";
    document.getElementById('tagit-1').value = "";
    document.getElementById('tagit-1-select').value = "";
    document.getElementById('tagit-2').value = "";
    document.getElementById('tagit-2-select').value = "";
    document.getElementById('tagit-3').value = "";
    document.getElementById('tagit-3-select').value = "";
    document.getElementById('addMatalaButton').setAttribute("onClick", "addOrEditMatala()");
    if(bool){
        makeRequest('get').then(data => {
            AllData = data;
            buildMatalot();
        });
    }
}

function SaveMatalot() {
    let TempData = {
        'todo': [],
        'doing': [],
        'done': [],
        'count': AllData.count
    };
    ['todo', 'doing', 'done'].forEach((key) => {
        $('#' + key + ' > div').each(function() {
            let id = $(this).data('matalaid');
            var matala = findMatla(id);
            matala.type = key;
            TempData[key].push(matala);
        });
    });
    makeRequest('save', {
        'data': JSON.stringify(TempData)
    });
}

function getTagitClass(type) {
    if (type == '1') {
        return 'uk-label-success';
    } else if (type == '2') {
        return 'uk-label-warning';
    } else if (type == '3') {
        return 'uk-label-danger';
    } else if (type == '4') {
        return '';
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
        text += '<div class="uk-margin" data-matalaid="' + element.id + '"><div class="uk-card uk-card-default uk-card-body uk-card-small uk-text-center" style="padding-top:7px !important;">';
        if (element.tagiot.length > 0) {
            text += '<div class="label-containter uk-text-left uk-accordion-content uk-overflow-auto">';
            element.tagiot.forEach(tagit => {
                text += '<span class="uk-margin-small-left uk-label ' + getTagitClass(tagit.type) + '">' + tagit.name + '</span>';
            });
            text += '</div>';
        }
        text += '<ul uk-accordion="toggle: > .uk-accordion-title" class="">';
        text += '<li>';
        text += '<a class="uk-accordion-title uk-text-bold uk-overflow-auto" href="#">' + element.title + '</a>';
        text += '<div class="uk-accordion-content uk-overflow-auto">';
        text += '<p>' + element.description + '</p>';
        text += '<p class="uk-text-small uk-text-left">' + new Date(element.date).toLocaleString() + '<a href="#" title="עריכה" uk-icon="icon: pencil" onclick="editMatala(' + element.id + ')"></a>';
        text += '<a href="#" title="העברה לארכיון" uk-icon="icon: pull" onclick="archiveMatala(' + element.id + ')"></a>';
        text += '<a href="#" title="מחיקה" uk-icon="icon: trash" onclick="deleteMatala(' + element.id + ')"></a>' + '</p>';
        text += '</div></li></ul></div></div>';
    });
    $('#' + name).html(text);
}

function addOrEditMatala(id = undefined) {
    SaveMatalot();
    let title = document.getElementById('matalaTitle').value;
    let description = document.getElementById('matalaDescription').value;
    let tagit1 = document.getElementById('tagit-1').value;
    let tagit1type = document.getElementById('tagit-1-select').value;
    let tagit2 = document.getElementById('tagit-2').value;
    let tagit2type = document.getElementById('tagit-2-select').value;
    let tagit3 = document.getElementById('tagit-3').value;
    let tagit3type = document.getElementById('tagit-3-select').value;
    if (title == "" || title == undefined) {
        alert("הכותרת ריקה");
        return;
    }
    if (description == "" || description == undefined) {
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
        'description': description,
        'tagiot': tagiot,
    };
    
    if(id !== undefined){
        matala.id = id;
        
        makeRequest('edit', {
            'matala': JSON.stringify(matala)
        }).then(data => {
            if (data.ok) {
                UIkit.notification({
                    message: "<span uk-icon='icon: check'></span> המטלה עודכנה",
                    pos: 'top-right'
                });
                init(true);
            }
        });
    }
    else{
        makeRequest('add', {
            'matala': JSON.stringify(matala)
        }).then(data => {
            if (data.ok) {
                UIkit.notification({
                    message: "<span uk-icon='icon: check'></span> המטלה נוספה",
                    pos: 'top-right'
                });
                init(true);
            }
        });
    }
}

function editMatala(id){
    var matala = findMatla(id);
    
    document.getElementById('addMatalaTitle').innerText = "עריכת מטלה";
    document.getElementById('addMatalaButton').innerText = "שמור";
    document.getElementById('addMatalaButton').setAttribute("onClick", "addOrEditMatala("+id+")");

    document.getElementById('matalaTitle').value = matala.title;
    document.getElementById('matalaDescription').value = matala.description.replace(/<br \/>/g, "");
    if(matala.tagiot[0] != undefined){
        document.getElementById('tagit-1').value = matala.tagiot[0].name;
        document.getElementById('tagit-1-select').value = matala.tagiot[0].type;
    }
    else{
        document.getElementById('tagit-1').value = "";
        document.getElementById('tagit-1-select').value = "";
    }
    if(matala.tagiot[1] != undefined){
        document.getElementById('tagit-2').value = matala.tagiot[1].name;
        document.getElementById('tagit-2-select').value = matala.tagiot[1].type;
    }
    else{
        document.getElementById('tagit-2').value = "";
        document.getElementById('tagit-2-select').value = "";
    }
    if(matala.tagiot[2] != undefined){
        document.getElementById('tagit-3').value = matala.tagiot[2].name;
        document.getElementById('tagit-3-select').value = matala.tagiot[2].type;
    }
    else{
        document.getElementById('tagit-3').value = "";
        document.getElementById('tagit-3-select').value = "";
    }
    
    var modal = UIkit.modal("#add-matala-modal");
    modal.show(); 
    
    //alert('בבניה!');
}

function archiveMatala(id) {
    SaveMatalot();
    if(confirm("האם אתה בטוח שאתה רוצה להעביר לארכיון את המטלה הזה?")){
        makeRequest('archive', {
            'id': id
        }).then(data => {
            if (data.ok) {
                UIkit.notification({
                    message: "<span uk-icon='icon: check'></span> המטלה הועברה לארכיון",
                    pos: 'top-right'
                });
                init(true);
            }
        });
    }
}

function deleteMatala(id) {
    SaveMatalot();
    if(confirm("האם אתה בטוח שאתה רוצה למחוק את המטלה הזה?")){
        makeRequest('delete', {
            'id': id
        }).then(data => {
            if (data.ok) {
                UIkit.notification({
                    message: "<span uk-icon='icon: check'></span> המטלה נמחקה",
                    pos: 'top-right'
                });
                init(true);
            }
        });
    }
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

window.onbeforeunload = function() {
    setTimeout(SaveMatalot, 0);
    return;
};