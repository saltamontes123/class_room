'use strict';

navigator.getUserMedia = navigator.getUserMedia ||
                         navigator.webkitGetUserMedia ||
                         navigator.mozGetUserMedia;

var constraints = {audio: false, video: true};

var start = document.querySelector('#start');
var snapshot = document.querySelector('#snapshot');
var filter = document.querySelector('#filter');
var video = document.querySelector('video');
var canvas = document.querySelector('canvas');

var filters = ['blur', 'brightness', 'contrast', 'grayscale', 'hue', 'invert', 'saturate', 'sepia'];

start.addEventListener('click', function() {
   navigator.getUserMedia(constraints, success, error);
});

function success(stream) {
   start.style.display = 'none';
   snapshot.style.display = 'block';
   filter.style.display = 'block';
   if (window.URL) {
      video.src = window.URL.createObjectURL(stream);
   } else {
      video.src = stream;
   }
}

function error(e) {
   console.log('navigator.getUserMedia error: ', e);
}

filter.addEventListener('click', function() {
   var index = (filters.indexOf(canvas.className) + 1) % filters.length;
   video.className = filters[index];
   canvas.className = filters[index];
});

snapshot.addEventListener('click', function() {
   canvas.width = 360;
   canvas.height = 270;
   canvas.getContext('2d').drawImage(video, 0, 0, canvas.width, canvas.height);
});