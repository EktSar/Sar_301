// Функция выбора активного меню
$(function () {
    let location = window.location.href;
    let curUrl = '/' + location.split('/').pop();
    curUrl = curUrl.split('?').shift();
    console.log(curUrl);

    $('.menu li a, .hidden__menu li a').each(function () {
        let link = $(this).attr('href');
        console.log(link);

        if (curUrl === link) {
            $(this).addClass('action');
        }
    });
});

// Меню-гамбургер
function clickHamburger() {
    $('.hidden').slideToggle(300);
}

function isEmail(email) {
    const regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    return regex.test(email);
}

function goPersonalRating(id) {
    window.location.href = window.origin + '/admin/personal_rating.php/?id=' + id;
}

// Страница с выводом соревнований по месяцам в личном кабинете студента
const pageCompList = document.querySelector('.months-list');
if (pageCompList) {
    pageCompList.addEventListener('click', evt => {
        if (evt.target.classList && evt.target.classList.contains('months-item__toggle')) {
            let path = evt.path || (evt.composedPath && evt.composedPath());
            Array.from(path).forEach(element => {
                if (element.classList && element.classList.contains('page-months__item')) {
                    element.classList.toggle('months-item--active');
                }
            });
            evt.target.classList.toggle('months-item__toggle--active');
        }
    });
}

// АДМИНКА
// Добавление (изменение) студента
const formStudent = document.querySelector('.form-student');
if (formStudent) {
    $("#phone").mask("+7 999 999 99 99"); // Маска для телефона
    $("#year_acceptance").mask("2099"); // Маска для телефона
}

// Удаление
const tableStudents = document.querySelector('.table-students');
if (tableStudents) {
    let btnDel;

    // Модально окно
    $('#model-delete').on('show.bs.modal', function (event) {
        btnDel = event.relatedTarget;
        let button = $(btnDel); // Кнопка-крестик
        const content = button.data('content');
        const modal = $(this);

        modal.find('.modal-body').text(content); // Вставить контент в модальное окно
    });

    // Удаление студента по кнопке Удалить
    $('.btn-delete-student').click(evt => {
        const studentId = $(btnDel).data('id');

        // ajax (post)
        $.post( "/admin/students.php",
            {
                del_student: true,
                studentId, // Id студента
            },
            function( data ) {
                tableStudents.removeChild(btnDel.parentElement.parentElement); // удаляем строку с удаленным студентом

                // Меняем номера строк таблицы
                let numbers = tableStudents.querySelectorAll('.num');
                numbers.forEach((num, i) => {
                    num.textContent = (i + 1).toString();
                });

                //console.log(data);
            }
        );
    });
}

const tableCompetitions = document.querySelector('.table-competitions');
if (tableCompetitions) {
    let btnDel;

    // Модально окно
    $('#model-delete').on('show.bs.modal', function (event) {
        btnDel = event.relatedTarget;
        let button = $(btnDel); // Кнопка-крестик
        const content = button.data('content');
        const modal = $(this);

        modal.find('.modal-body').text(content); // Вставить контент в модальное окно
    });

    // Удаление соревнования по кнопке Удалить
    $('.btn-delete-competition').click(evt => {
        const competitionId = $(btnDel).data('id');

        // ajax (post)
        $.post( "/admin/competitions.php",
            {
                del_competition: true,
                competitionId, // Id соревнования
            },
            function( data ) {
                tableCompetitions.removeChild(btnDel.parentElement.parentElement); // удаляем строку с удаленным студентом

                // Меняем номера строк таблицы
                let numbers = tableCompetitions.querySelectorAll('.num');
                numbers.forEach((num, i) => {
                    num.textContent = (i + 1).toString();
                });

                //console.log(data);
            }
        );
    });
}
