<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Stopwatch</title>
    <style>
        .circle {
            width: 204px;
            height: 204px;
            border: 2px solid #000;
            border-radius: 50%;
            position: relative;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .bullet {
            width: 10px;
            height: 10px;
            background: red;
            border-radius: 50%;
            position: absolute;
            top: -5px;
            left: 95px;
            transform-origin: 5px 105px;
            animation: revolve 1s linear infinite;
            animation-play-state: paused;
        }
        @keyframes revolve {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }
        #time {
            font-size: 24px;
            position: absolute;
        }
        @keyframes revolve {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }

        button {
            margin: 10px;
            padding: 10px 20px;
            font-size: 16px;
            border: none;
            cursor: pointer;
        }
        #splits {
            margin-top: 20px;
        }
        .splits-section {
            margin-top: 30px;
            text-align: center;
        }
        #splits-table {
            margin: 0 auto;
            border-collapse: collapse;
        }
        #splits-table th, #splits-table td {
            border: 1px solid #000;
            padding: 8px;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-2">
                <div class="ad-vertical">
                    <h1>Advertisement</h1>
                </div>
            </div>
            <div class="col-8">
                <div class="stopwatch text-center bg-light p-4 rounded">
                    <h1>Stopwatch</h1>
                    <div class="circle mx-auto">
                        <div class="bullet"></div>
                        <div id="time">00:00:00.00</div>
                    </div>
                    <button id="toggle" class="btn btn-success me-2">Start</button>
                    <button id="split" class="btn btn-primary me-2">Split</button>
                    <button id="reset" class="btn btn-warning">Reset</button>
                </div>
                <div class="splits-section bg-light p-4 rounded">
                    <h2>Splits</h2>
                    <div style="max-height: 300px; overflow-y: auto;">
                        <table id="splits-table" class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Split #</th>
                                    <th>Time</th>
                                </tr>
                            </thead>
                            <tbody id="splits-body"></tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-2">
                <div class="ad-vertical">
                    <h1>Advertisement</h1>
                </div>
            </div>
        </div>
    </div>

    <script>
        let startTime;
        let elapsedTime = 0;
        let timerInterval;
        let pageStartTime = Date.now();
        let splitCount = 0;
        let latitude = null;
        let longitude = null;

        // Request geolocation
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(
                (position) => {
                    latitude = position.coords.latitude;
                    longitude = position.coords.longitude;
                },
                (error) => {
                    console.log('Geolocation error:', error.message);
                }
            );
        }

        const timeDisplay = document.getElementById('time');
        const bullet = document.querySelector('.bullet');
        const toggleBtn = document.getElementById('toggle');
        const splitBtn = document.getElementById('split');
        const resetBtn = document.getElementById('reset');
        const splitsBody = document.getElementById('splits-body');

        function formatTime(ms) {
            const totalSeconds = Math.floor(ms / 1000);
            const hours = Math.floor(totalSeconds / 3600);
            const minutes = Math.floor((totalSeconds % 3600) / 60);
            const seconds = totalSeconds % 60;
            const milliseconds = Math.floor((ms % 1000) / 10); // centiseconds
            return `${hours.toString().padStart(2, '0')}:${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}.${milliseconds.toString().padStart(2, '0')}`;
        }

        function updateTime() {
            elapsedTime = Date.now() - startTime;
            timeDisplay.textContent = formatTime(elapsedTime);
        }

        toggleBtn.addEventListener('click', () => {
            if (timerInterval) {
                // Stop
                clearInterval(timerInterval);
                timerInterval = null;
                bullet.style.animationPlayState = 'paused';
                toggleBtn.textContent = 'Start';
                toggleBtn.classList.remove('btn-danger');
                toggleBtn.classList.add('btn-success');
            } else {
                // Start
                startTime = Date.now() - elapsedTime;
                timerInterval = setInterval(updateTime, 10);
                bullet.style.animationPlayState = 'running';
                toggleBtn.textContent = 'Stop';
                toggleBtn.classList.remove('btn-success');
                toggleBtn.classList.add('btn-danger');
            }
        });

        splitBtn.addEventListener('click', () => {
            if (timerInterval) {
                splitCount++;
                const splitTime = formatTime(elapsedTime);
                const row = document.createElement('tr');
                const numCell = document.createElement('td');
                numCell.textContent = splitCount;
                const timeCell = document.createElement('td');
                timeCell.textContent = splitTime;
                row.appendChild(numCell);
                row.appendChild(timeCell);
                splitsBody.insertBefore(row, splitsBody.firstChild);
            }
        });

        resetBtn.addEventListener('click', () => {
            clearInterval(timerInterval);
            timerInterval = null;
            elapsedTime = 0;
            timeDisplay.textContent = '00:00:00.00';
            bullet.style.animationPlayState = 'paused';
            toggleBtn.textContent = 'Start';
            toggleBtn.classList.remove('btn-danger');
            toggleBtn.classList.add('btn-success');
            splitsBody.innerHTML = '';
            splitCount = 0;
        });

        // Capture and send data on page unload
        window.addEventListener('beforeunload', () => {
            const timeSpent = Math.floor((Date.now() - pageStartTime) / 1000);

            // Get device type
            const deviceType = /Mobi|Android/i.test(navigator.userAgent) ? 'mobile' : 'desktop';

            // Get user agent
            const userAgent = navigator.userAgent;

            // Get IP address (will be handled server-side)
            const ipAddress = ''; // Server will get it

            // Send data with location
            sendData(deviceType, userAgent, ipAddress, latitude, longitude, timeSpent);
        });

        function sendData(deviceType, userAgent, ipAddress, latitude, longitude, timeSpent) {
            const data = new FormData();
            data.append('device_type', deviceType);
            data.append('user_agent', userAgent);
            data.append('ip_address', ipAddress);
            data.append('latitude', latitude || '');
            data.append('longitude', longitude || '');
            data.append('time_of_visit', new Date(pageStartTime).toISOString());
            data.append('time_spent', timeSpent);
            data.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));

            // Send POST request using sendBeacon for reliability on unload
            navigator.sendBeacon('/visit', data);

            // console.log('=================',data,'=================');

        }
    </script>
</body>
</html>