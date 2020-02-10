/*
 * This file is part of Emotionally.
 *
 * Emotionally is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * Emotionally is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Emotionally.  If not, see <http://www.gnu.org/licenses/>.
 */

"use strict";

$ = require('jquery');

const EmotionAnalysis = {
    /**
     * Analyze a video.
     * @param filename {string} The path to the video file.
     * This is relative to the current location in the server.
     * @param secs {number} Where to start (in seconds)
     * @param sec_step {number} The step size of extracting emotion (in seconds).
     * @param stop_sec {number} Where to stop (in seconds). If undefined or less or equal to secs, the entire video will be analyzed.
     */
    analyzeVideo: function (filename, secs = 0, sec_step = 0.1, stop_sec = undefined) {
        // Set verbose = true to print images and detection succes, false if you don't want info
        var verbose = false;

        // Decide whether your video has large or small face
        var faceMode = affdex.FaceDetectorMode.SMALL_FACES;
        // var faceMode = affdex.FaceDetectorMode.LARGE_FACES;

        // Decide which detector to use photo or stream
        // var detector = new affdex.PhotoDetector(faceMode);
        var detector = new affdex.FrameDetector(faceMode);

        // Initialize Emotion and Expression detectors
        detector.detectAllEmotions();
        detector.detectAllExpressions();

        // Init variable to save results
        var detection_results = []; // for logging all detection results.
        if (typeof stop_sec === 'undefined' || stop_sec <= secs) {
            stop_sec = Infinity
        }

        // Get video duration and set as global variable;
        var me = this, video = document.createElement('video');
        video.src = filename;
        // video.crossOrigin = 'anonymous';
        var duration;
        // print success message when duration of video is loaded.
        video.onloadedmetadata = function () {
            duration = this.duration;
            log("#logs", "Duration has been loaded for file: " + video.src)
        };

        // Initialize detector
        log("#logs", "Initializing detector...");
        detector.start();

        //Add a callback to notify when the detector is initialized and ready for runing.
        detector.addEventListener("onInitializeSuccess", function () {
            log("#logs", "The detector reports initialized");
            getVideoImage(secs);
        });

// This portion grabs image from the video
        function getVideoImage(secs) {
            video.currentTime = Math.min(Math.max(0, (secs < 0 ? video.duration : 0) + secs), video.duration);
            video.onseeked = function (e) {
                var canvas = document.createElement('canvas');
                canvas.crossOrigin = 'anonymous';
                canvas.height = canvas.height;
                canvas.width = canvas.width;
                // canvas.width = 640;
                // canvas.height = 480;

                var ctx = canvas.getContext('2d');
                ctx.drawImage(video, 0, 0, canvas.width, canvas.height);
                var img = new Image();
                img.src = canvas.toDataURL();
                if (verbose) {
                    document.getElementById("logs").appendChild(img);
                    document.getElementById("logs").appendChild(document.createElement("br"));
                }
                // Pass the image to the detector to track emotions
                if (detector && detector.isRunning) {
                    log("#logs", "Processing second : ".concat(precisionRound(secs, 3).toString()));
                    detector.process(ctx.getImageData(0, 0, canvas.width, canvas.height), secs);
                }

            };
            video.onerror = function (e) {
                console.log("Video Seeking Error");
            };
        }

        detector.addEventListener("onImageResultsSuccess", function (faces, image, timestamp) {
            // drawImage(image);
            $('#results').html("");
            var time_key = "Timestamp";
            var time_val = timestamp;
            console.log('#results', "Timestamp: " + timestamp.toFixed(2));
            console.log('#results', "Number of faces found: " + faces.length);
            if (verbose) {
                log("#logs", "Number of faces found: " + faces.length);
            }
            if (faces.length > 0) {
                // Append timestamp
                faces[0].emotions[time_key] = time_val;
                // Save both emotions and expressions
                var json = JSON.stringify(Object.assign({}, faces[0].emotions, faces[0].expressions));
                detection_results.push(json);
            } else {
                // If face is not detected skip entry.
                console.log('Cannot find face, skipping entry');
            }

            if (duration >= secs && stop_sec >= secs) {
                secs = secs + sec_step;
                getVideoImage(secs);
            } else {
                console.log("EndofDuration");
                let report = JSON.stringify(detection_results);
                // var blob = new Blob(report, {type: "application/json"});
                console.log(report);
                // var saveAs = window.saveAs;
                // saveAs(blob, filename.split(".")[0].concat(".json"));
            }

        });

        function log(node_name, msg) {
            // Function from affectiva demo to write log on html page.
            // First var is div name, second var message.
            $(node_name).append("<span>" + msg + "</span><br />")
        }

        function precisionRound(number, precision) {
            var factor = Math.pow(10, precision);
            return Math.round(number * factor) / factor;
        }
    }
};


exports.default = EmotionAnalysis;
// export default EmotionAnalysis;
