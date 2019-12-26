/*! Todo list | https://yehudae.ga | (c) 2019 Yehuda Eisenberg | MIT License */ 

var AllData;
var API_URL = "?api&method=";
var TempMatala;
$(() => init());

function init() {
    makeRequest('getArchive').then(data => {
        AllData = data;
        buildMatalot();
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
    buildMatala('archive1');
    buildMatala('archive2');
    buildMatala('archive3');
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
        text += '<p class="uk-text-small uk-text-left">' + new Date(element.date).toLocaleString();
        text += '<a href="#" title="שחזור" uk-icon="icon: push" onclick="unArchiveMatala(' + element.id + ')"></a>';
        text += '<a href="#" title="מחיקה" uk-icon="icon: trash" onclick="deleteMatala(' + element.id + ')"></a>' + '</p>';
        text += '</div></li></ul></div></div>';
    });
    $('#' + name).html(text);
}

function deleteMatala(id) {
    if(confirm("האם אתה בטוח שאתה רוצה למחוק את המטלה הזה?")){
        makeRequest('delete', {
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
}

function unArchiveMatala(id) {
    if(confirm("האם אתה בטוח שאתה רוצה לשחזר את המטלה הזה?")){
        makeRequest('unArchive', {
            'id': id
        }).then(data => {
            if (data.ok) {
                UIkit.notification({
                    message: "<span uk-icon='icon: check'></span> המטלה שוחזרה",
                    pos: 'top-right'
                });
                init();
            }
        });
    }
}

function makeRequest(method, params = '') {
    return $.ajax({
        type: "post",
        url: API_URL + method,
        data: params,
        dataType: "json",
    });
}