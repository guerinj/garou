let voice = null;

export const sayThis = (text) => {
    if (!text) return;

    if (!voice) {
        speechSynthesis.onvoiceschanged = () => {
            voice = speechSynthesis.getVoices().find(v => v.lang == 'fr-FR');
            sayThis(text);
            speechSynthesis.onvoiceschanged = null;
        }

        const voices = speechSynthesis.getVoices();
        return;
    }
    const utterance = new SpeechSynthesisUtterance(text);
    utterance.voice = voice;
    window.speechSynthesis.speak(utterance);
    return history;
};

