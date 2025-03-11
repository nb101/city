import React, { useState } from 'react';
import ReactDOM from 'react-dom/client';
import axios from 'axios';

function CitiesQuiz() {
    const [question, setQuestion] = useState(null);
    const [error, setError] = useState('');
    const [showAnswer, setShowAnswer] = useState(false);
    const [correctAnswer, setCorrectAnswer] = useState('');
    const [isCorrect, setIsCorrect] = useState(false);

    const fetchQuestion = () => {
        axios.get('/api/questions')
            .then(response => {
                setQuestion(response.data);
                setShowAnswer(false);
                setIsCorrect(false);
                setError('');
            })
            .catch(error => {
                setError('Error fetching question. Please try again.');
                setQuestion(null);
            });
    };

    const handleAnswer = (selectedCapital) => {
        axios.get('/api/answers', { params: { country: question.country, capital: selectedCapital } })
            .then(response => {
                if (response.data.correct) {
                    setIsCorrect(true);
                    setShowAnswer(false);
                } else {
                    setCorrectAnswer(response.data.correct_capital);
                    setShowAnswer(true);
                    setIsCorrect(false);
                }
                setError('');
            })
            .catch(() => {
                setError('Error checking answer. Please try again.');
            });
    };

    const handleClose = () => {
        window.close();
    };

    return (
        <div className="quiz-container">
            {error && <p>{error}</p>}
            {question ? (
                <>
                    <h1>{question.country}</h1>
                    <div>
                        {question.options.map((capital, index) => (
                            <button key={index} onClick={() => handleAnswer(capital)}>
                                {capital}
                            </button>
                        ))}
                    </div>
                    {isCorrect && <p>That is the correct answer!</p>}
                    {showAnswer && <p>Wrong! Correct Answer: {correctAnswer}</p>}
                    <button onClick={fetchQuestion}>Next Question</button>
                </>
            ) : (
                <button onClick={fetchQuestion}>Start Quiz</button>
            )}
            <button onClick={handleClose}>Close Window</button>
        </div>
    );
}

if (document.getElementById('app')) {
    const root = ReactDOM.createRoot(document.getElementById('app'));
    root.render(
        <React.StrictMode>
            <CitiesQuiz />
        </React.StrictMode>
    );
}
