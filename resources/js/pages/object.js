$(document).ready(function(){
    $('.form-horizontal').on('submit', function (e) {
        var day = new Date();
        var dateSubmit = $('#year').val() + `.` + $('#month').val();
        var nowDate = day.getFullYear() + `.` + (day.getMonth() + 1);
        console.log(dateSubmit,nowDate)
        
        if (dateSubmit >= nowDate){
            alert(`На этот месяц данных о расходе ресурсов ещё нет.`);
            e.preventDefault();
        }
    });
});