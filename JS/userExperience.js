var alertBoxes = [];
var intervals = [];
var fadeManagers = [];

var speedResolution = 10;

function initResponsive() {
    var winHeight = window.innerHeight;
    var headerHeight =  document.getElementById("page-header-wrapper").offsetHeight; //computed values
    var footerHeight = document.getElementById('footer-wrapper').offsetHeight; //computed values

    document.getElementById("body-wrapper").style.minHeight = winHeight - headerHeight - footerHeight + "px";
}

function timedAlert(message, transitTime= 1500, holdTime = 2000){
    var alertBox = document.createElement("div");
    alertBox.className = "alert-box";
    alertBox.style.opacity = 0;

    var timer = document.createElement("div");
    timer.className = "boxTimer";
    timer.appendChild(document.createTextNode(1 + parseInt((holdTime + 2 * transitTime) / 1000)));

    var messageBox = document.createElement("p");
    messageBox.appendChild(document.createTextNode(message));

    var closeButton = document.createElement("div");
    closeButton.className = "button";
    closeButton.appendChild(document.createTextNode("Close"));

    alertBox.appendChild(timer);
    alertBox.appendChild(messageBox);

    var size = alertBoxes.length;
    alertBoxes[size] = alertBox;
    fadeManagers[size] = new FadeManager(size, transitTime, holdTime);
    intervals[size] = setInterval(function(){ fadeManagers[size].fade(); }, speedResolution);

    closeButton.onclick = function () { fadeManagers[size].skip() };
    alertBox.appendChild(closeButton);

    document.body.insertBefore(alertBox, document.body.firstChild);

}

var FadeManager = function (alertIndex, transitTime, holdTime){
    this.alertIndex = alertIndex;

    this.opacityStep = 1 / (transitTime / speedResolution);

    this.t1End = new Date().getTime() + transitTime + speedResolution;
    this.hEnd = this.t1End + holdTime;
    this.t2End = this.hEnd + transitTime + speedResolution;
}

FadeManager.prototype.fade = function () {
    if(new Date().getTime() < this.t1End){
        var oldOpacity = Number(alertBoxes[this.alertIndex].style.opacity);
        alertBoxes[this.alertIndex].style.opacity = oldOpacity + this.opacityStep;
    } else if(new Date().getTime() < this.hEnd){
        alertBoxes[this.alertIndex].style.opacity = 1;
    } else if(new Date().getTime() < this.t2End){
        var oldOpacity = Number(alertBoxes[this.alertIndex].style.opacity);
        alertBoxes[this.alertIndex].style.opacity = oldOpacity - this.opacityStep;
    } else {
        alertBoxes[this.alertIndex].style.opacity = 0;
        clearInterval(intervals[this.alertIndex]);
        document.body.removeChild(alertBoxes[this.alertIndex]);
        return;
    }

    document.getElementsByClassName('boxTimer')[alertBoxes.length - 1 - this.alertIndex].innerHTML = 1 + parseInt((this.t2End - new Date().getTime()) / 1000);
}

FadeManager.prototype.skip = function () {
    this.t1End = 0;
    this.hEnd = 0;
}
