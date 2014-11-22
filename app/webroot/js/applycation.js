/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$(function() {
});

function printElem(elem, title) {
    var content = '';
    $(elem).find('tr').each(function() {
        content += '<tr>';

        $(this).find('td').each(function() {
            if ($(this).is(':last-child')) {
            } else {
                content += '<td>';
                if ($(this).find('a').length > 0) {
                    $(this).find('a').each(function() {
                        content += $(this).html();
                        if ($(this).is(':last-child')) {
                        } else {
                            content += '<br/>';
                        }
                    })
                } else {
                    content += $(this).html();
                }
                content += '</td>';
            }
        });
        $(this).find('th').each(function() {
            if ($(this).is(':last-child')) {
            } else {
                content += '<th>';
                if ($(this).find('a').length > 0) {
                    $(this).find('a').each(function() {
                        content += $(this).html();
                    })
                } else {
                    content += $(this).html();
                }
                content += '</th>';
            }
        });

        content += '</tr>'
    });

    var headstr = "<html><head><title>abc</title></head><body>";
    var titlestr = "<h1>"+title+"</h1>";
    var tablestr = "<table border='1'>";
    tablestr += content;
    tablestr += "</table>";
    var footstr = "</body></html>";
    var oldstr = document.body.innerHTML;
    document.body.innerHTML = headstr + titlestr + tablestr + footstr;
    window.print();
    document.body.innerHTML = oldstr;

    return false;

}