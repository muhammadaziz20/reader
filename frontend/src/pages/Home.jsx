import { useRef, useState } from "react";
// import "./style.css";

function Home() {



    const audioRef = useRef(null);
    const [bookName, setBookName] = useState("");

    const availableBooks = {
        "Ul Jang Alangasi": "/ul_jang_alangasi.m4a",
    };

    function playAudio() {
        if (availableBooks[bookName]) {
            audioRef.current.src = availableBooks[bookName];
            audioRef.current.play();
        } else {
            alert("PDF tanlang");
        }
    }

    function pauseResumeAudio() {
        if (audioRef.current.paused) {
            audioRef.current.play();
        } else {
            audioRef.current.pause();
        }
    }

    function stopAudio() {
        audioRef.current.pause();
        audioRef.current.currentTime = 0;
    }

    function rewindAudio() {
        audioRef.current.currentTime = Math.max(
            0,
            audioRef.current.currentTime - 5
        );
    }

    function forwardAudio() {
        audioRef.current.currentTime = Math.min(
            audioRef.current.duration,
            audioRef.current.currentTime + 5
        );
    }

    return (
        <header>
            <div className="first">
                <h2>Kitob nomini kiriting</h2>
                <input
                    type="text"
                    placeholder="Kitob nomi"
                    className="name"
                    value={bookName}
                    onChange={(e) => setBookName(e.target.value)}
                />
            </div>

            <div className="controls">
                <button className="play" onClick={playAudio}>Play</button>
                <button className="pause" onClick={pauseResumeAudio}>
                    Pause / Resume
                </button>
                <button className="stop" onClick={stopAudio}>Stop</button>
                <button className="go" onClick={rewindAudio}>
                    {"<<"} 5s
                </button>
                <button className="back" onClick={forwardAudio}>
                    5s {">>"}
                </button>

                <audio ref={audioRef} />
            </div>
        </header>
    );
}

export default Home;
