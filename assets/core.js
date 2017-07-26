function run(cmd, page, mode) {
    if (!mode) {
        var mode = "";
    }
    $('#inti').html('<div class="hero"><div class="hero-body has-text-centered"><span class="subtitle">Loading ' + page + '</span></div></div>');
    $.ajax({
        type: "POST",
        url: "do.php",
        data: { 'cmd': cmd, 'page': page },
        success: function(data) {
            $('#inti').hide().html(data).velocity("transition.fadeIn");
        }
    });
}
var cnt = 0;
var i = 0;

function check() {
    setInterval(function() {
        $.ajax({
            type: "POST",
            url: "checker.php",
            success: function(data) {
                if (data > cnt) {
                    if (i == 0) {
                        cnt = data;
                    } else {
                        cnt = data;
                        notify('info','Ada pemesanan baru');
                        run("get", "orders");
                    }
                    i = 1;
                }
            }
        });
    }, 1000);
};


function openmodal(page) {
    $('.modyal').siblings().velocity({ blur: '2px', });
    $.ajax({
        type: "POST",
        url: "do.php",
        data: { 'cmd': "get", 'page': page },
        success: function(data) {
            $('.modyal').html(data).delay(500).velocity("transition.slideUpBigIn", { duration: 800, easing: "easeInOutSine" });
        }
    });
}

function notify(type, msg) {
    $('.modyal').html('<div class="notification is-' + type + '">' + msg + '</div>');
    $('.modyal').velocity("transition.slideUpBigIn").delay(2500).velocity("reverse");
    $('.modyal').siblings().velocity({ blur: '0px' });
    $('.modyal').queue(function() {
        $('.modyal').html("").dequeue();
    });
}

function toggledit() {
    if ($('.ed').parent().hasClass('is-selected')) {
        run('get', 'vehicles');
    } else {
        $(".ed").toggle(100);
    }

}

function editmode() {
    if ($('.edit').is(':visible')) {
        run('get', 'orders');
    } else {
        $(".ed").toggle(100);
    }

}

function edittanki(item) {
    var uid = item;
    item = '#' + item;
    $(item).toggleClass('is-selected');
    $(item).prev().toggleClass('is-selected');
    $.ajax({
        type: "POST",
        url: "do.php",
        data: { 'cmd': "get", 'page': "edittanki", 'uid': uid },
        success: function(data) {
            $(item).toggle(100).html(data);
        }
    });
}

function editorder(item) {
    var ido = item;
    item = '#' + item;
    $.ajax({
        type: "POST",
        url: "do.php",
        data: { 'cmd': "get", 'page': "editorder" },
        success: function(data) {
            $(item).html(data).toggle(100);
            $('.stat').toggle();
            $(item).find("input[name='ido']").val(ido);
        }
    });
}

function editadmin() {
    if ($('#inti').find('#dataadmin').length) {
        $('body').find('.tabs').velocity('reverse');
        $('li[page="orders"]').addClass('is-active');
        run('get', 'orders');
    } else {
        $('body').find('.tabs').velocity('transition.slideUpBigOut');
        run('get', 'adminedit');
    }
};

function deletetanki(item) {
    if (confirm('Yakin?')) {
        $.ajax({
            type: "POST",
            url: "do.php",
            data: { 'cmd': "set", 'type': "deletetanki", 'uid': item },
            success: function(data) {
                alert(data);
                run('get', 'vehicles');
            }
        });
    }
}

function deleteorder(item) {
    $.ajax({
        type: "POST",
        url: "do.php",
        data: { 'cmd': "set", 'type': "deleteorder", 'ido': item },
        success: function(data) {
            notify("info", data);
            run('get', 'orders');
        }
    });
}


function processform(form, data, okmsg) {
    $.ajax({
        type: 'POST',
        url: 'do.php',
        data: data,
        success: function(data) {
            if (data == "ok") {
                notify("success", okmsg);
                run("get", "profile");
            } else {
                $(form).find("input[type='submit']").removeClass('is-loading');
                $(form).find(".field").filter(":first").before('<div class="notification is-warning">' + data + '</div>');
            }
        }

    });
}

function checkusername(elem) {
    var help=$('#form1').find('.field:eq(1)').find('.help');
    var icon=elem.parent().find('.icon');
    console.log(elem.val());
    $.ajax({
        type: 'POST',
        url: 'do.php',
        data: { 'cmd' : "set", 'type' : "checkusername", 'uname' : elem.val() },
        success: function(data) {
            if (data == 'ok') {
                help.hide();
                icon.fadeIn();
                $('#form1').find("input[type='submit']").removeClass('is-static');
            } else {
                help.show();
                icon.fadeOut();
                $('#form1').find("input[type='submit']").addClass('is-static');
            }
        }
    });
}

function checktwice(elem) {
    var a = elem.parents(3).find("input[name='pass1']").val();
    var b = elem.val();
    if (a == b) {
        if (elem.hasClass('is-danger')) {
            elem.removeClass('is-danger');
        }
        elem.addClass('is-success');
    } else {
        if (elem.hasClass('is-success')) {
            elem.removeClass('is-success');
        }
        elem.addClass('is-danger');
    }
}

$(function() {
    $('.navbar-burger').click(function() {
        $(this).toggleClass('is-active');
        $(this).parents(2).find('.navbar-menu').toggleClass('is-active');
        $('body').find('#inti').toggle();
    });
    $('.menu').click(function() {
        var pg = $(this).attr('page');
        run('get', pg);
        $(this).parents(2).prev().find('.navbar-burger').removeClass('is-active');
        $(this).parents(2).removeClass('is-active');
    });
    $(".modyal").on("submit", "#form1", function(e) {
        e.preventDefault();
        if ($(this).find("input[type='submit']").hasClass('is-static')) {
            notify('danger',"username sudah digunakan")
        } else {
            processform($(this), $(this).serialize(), "Profil berhasil dirubah");
        }
    });
    $(".modyal").on("submit", "#form3", function(e) {
        e.preventDefault();
        $(this).find("input[type='submit']").addClass('is-loading');
        processform($(this), $(this).serialize(), "Password telah berhasil dirubah");
    });
    $(".modyal").on("submit", "#form2", function(e) {
        e.preventDefault();
        $(this).find("input[type='submit']").addClass('is-loading');
        processform($(this), $(this).serialize(), "Password telah berhasil dirubah");
    });
    $('.modyal').on('click', '.delete', function() {
        $('.modyal').velocity("reverse");
        $('.modyal').siblings().velocity({ blur: '0px' });
    })
});