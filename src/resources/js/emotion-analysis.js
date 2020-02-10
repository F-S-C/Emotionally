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
     * A callback to be used at the end of an analysis.
     * @callback AnalysisCompletedCallback
     * @param report {string} The generated report.
     */

    /**
     * Analyze a video.
     * @param {string} filename The path to the video file.
     * This is relative to the current location in the server.
     * @param {AnalysisCompletedCallback} [callback] A callback.
     * @param {Object} [options] The configuration of the analysis.
     * @param {number} [options.secs=0] Where to start (in seconds)
     * @param {number} [options.sec_step=0.1] The step size of extracting emotion (in seconds).
     * @param {number} [options.stop_sec=undefined] Where to stop (in seconds). If undefined or less or equal to secs, the entire video will be analyzed.
     */
    analyzeVideo: function (filename, callback = undefined, options = undefined) {
        // Set verbose = true to print images and detection succes, false if you don't want info
        if (options === undefined) {
            options = {
                secs: 0,
                sec_step: 0.1,
                stop_sec: undefined,
            };
        }

        const verbose = false;
        let secs = options.secs;
        let sec_step = options.sec_step;
        let stop_sec = options.stop_sec;

        // Decide whether your video has large or small face
        const faceMode = affdex.FaceDetectorMode.SMALL_FACES;
        // var faceMode = affdex.FaceDetectorMode.LARGE_FACES;

        // Decide which detector to use photo or stream
        // var detector = new affdex.PhotoDetector(faceMode);
        const detector = new affdex.FrameDetector(faceMode);

        // Initialize Emotion and Expression detectors
        detector.detectAllEmotions();
        detector.detectAllExpressions();

        // Init variable to save results
        let detection_results = []; // for logging all detection results.
        if (typeof stop_sec === 'undefined' || stop_sec <= secs) {
            stop_sec = Infinity
        }

        // Get video duration and set as global variable;
        let me = this, video = document.createElement('video');
        video.src = filename;
        // video.crossOrigin = 'anonymous';
        let duration;
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
                let canvas = document.createElement('canvas');
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
            const time_key = "Timestamp";
            const time_val = timestamp;
            console.log('#results', "Timestamp: " + timestamp.toFixed(2));
            console.log('#results', "Number of faces found: " + faces.length);
            if (verbose) {
                log("#logs", "Number of faces found: " + faces.length);
            }
            if (faces.length > 0) {
                // Append timestamp
                faces[0].emotions[time_key] = time_val;
                // Save both emotions and expressions
                const json = JSON.stringify(Object.assign({}, faces[0].emotions, faces[0].expressions));
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
                if (callback) callback(report);
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
            const factor = Math.pow(10, precision);
            return Math.round(number * factor) / factor;
        }
    }
};


exports.default = EmotionAnalysis;
// export default EmotionAnalysis;
