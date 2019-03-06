var deviceId = 2;
var url="../backend/fake.php"; // ?? questinable
var timer;

$(document).ready(function() {
  $("#startMonitoring").click(startMonitoring);
  $("#stopMonitoring").click(stopMonitoring);
  startMonitoring();
});

function startMonitoring() {
    performUpdate();
    timer = setInterval(performUpdate, 1000);
    setStatusPending();
}

function stopMonitoring() {
  clearInterval(timer);
  setStatusStop();
}

function setStatusRun(){
  $("#text-status").text('запущен')
  $("#box-status").removeClass();
  $("#box-status").addClass('bg-green');
  $("#box-status").addClass('box-header with-border');
}

function setStatusPending(){
  $("#text-status").text('выполняется обновление')
}

function setStatusError() {
  console.error("Ошибка обновления")
  $("#text-status").text('ошибка обновления')
  $("#box-status").removeClass();
  $("#box-status").addClass('bg-red-active');
  $("#box-status").addClass('box-header with-border');
  
}
function setStatusStop() {
  $("#text-status").text('остановлен')
  $("#box-status").removeClass();
  $("#box-status").addClass('box-header with-border');
}

function performUpdate(){
  $.ajax({
    url: url,
    type: 'GET',
    dataType: 'json',
    data: {deviceId: deviceId},
    beforeSend: setStatusPending
  })
  .done(renderData)
  .fail(setStatusError)
  .always();    
}

function renderData(data) {
  setStatusRun();
  renderParam(data,"p","p");
  renderParam(data,"q","q");
  renderParam(data,"s","s");
  renderParam(data,"f","f");
  renderParam(data,"u1","u1");
  renderParam(data,"i1","i1");
  renderParam(data,"p1","p1");
  renderParam(data,"q1","q1");
  renderParam(data,"s1","s1");
  renderParam(data,"phi1","fi1");
  renderParam(data,"u2","u2");
  renderParam(data,"i2","i2");
  renderParam(data,"p2","p2");
  renderParam(data,"q2","q2");
  renderParam(data,"s2","s2");
  renderParam(data,"phi2","fi2");
  renderParam(data,"u3","u3");
  renderParam(data,"i3","i3");
  renderParam(data,"p3","p3");
  renderParam(data,"q3","q3");
  renderParam(data,"s3","s3");
  renderParam(data,"phi3","fi3");
  console.log("Обновление выполнено");
}

function renderParam(data,holderId,paramName){
  $("#"+holderId).text(data[paramName]);
}