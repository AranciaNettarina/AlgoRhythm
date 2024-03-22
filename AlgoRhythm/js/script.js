document.addEventListener("DOMContentLoaded", function() {

    window.onSpotifyWebPlaybackSDKReady = () => {
        const player = new Spotify.Player({
            name: 'Web Playback SDK Quick Start Player',
            getOAuthToken: cb => { cb(token); },
            volume: 1,
        });
    
        player.addListener('initialization_error', ({ message }) => {
            console.error('Initialization Error:', message);
        });
        player.addListener('authentication_error', ({ message }) => {
            console.error('Authentication Error:', message);
        });
        player.addListener('account_error', ({ message }) => {
            console.error('Account Error:', message);
        });
        player.addListener('playback_error', ({ message }) => {
            console.error('Playback Error:', message);
        });
    
        player.addListener('ready', ({ device_id }) => {
            console.log('Ready with Device ID', device_id);
    
            fetch(`https://api.spotify.com/v1/me/player/play?device_id=${device_id}`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'Authorization': `Bearer ${token}`,
                },
                body: JSON.stringify({
                    uris: [`spotify:track:${trackId}`],
                }),
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! Status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                console.log('Playback started:', data);
            })
            .catch(error => {
                console.error('Error starting playback:', error);
            });

            setInterval(() => {
                player.getCurrentState().then(state => {
                    if (state && state.position !== null && state.duration !== null) {
                        const currentPosition = state.position / 1000; 
                        const duration = state.duration / 1000; 
                        const seekBar = document.getElementById('seekBar');
                        seekBar.max = duration;
                        seekBar.value = currentPosition;
                    }
                }).catch(error => {
                    console.error('Error getting current playback state:', error);
                });
            }, 1000); 
        });
    
        player.addListener('not_ready', ({ device_id }) => {
            console.log('Device ID has gone offline', device_id);
        });
    
        document.getElementById('togglePlay').onclick = function() {
            player.togglePlay();
        };
    
        document.getElementById('nextTrack').onclick = function() {
            player.nextTrack();   
        };
    
        document.getElementById('previousTrack').onclick = function() {
            player.previousTrack();
        };
        
        player.addListener('player_state_changed', state => {
            if (state) {
                const duration = state.duration / 1000;
                document.getElementById('seekBar').max = duration;
            }
        });
    
        document.getElementById('seekBar').oninput = function() {
            const seekValue = parseInt(this.value);
            player.seek(seekValue * 1000); 
        };
    
        player.connect();
    };
    
    document.getElementById("logoutButton").addEventListener("click", function() {
        function logout() {
            var logoutWindow = window.open('https://www.spotify.com/logout', '_blank');
                
            var xhr = new XMLHttpRequest();
            xhr.open("GET", "logout.php", true);
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    window.location.href = "index.html";
                }
            };
            xhr.send();
        }
        logout();
    });
});
