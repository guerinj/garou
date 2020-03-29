let voice = null;
export const sayThis = (text) => {
    if (!text) return;

    if (!voice) {
        const voices = speechSynthesis.getVoices();

        speechSynthesis.onvoiceschanged = () => {
            voice = speechSynthesis.getVoices().find(v => v.lang == 'fr-FR');
            sayThis(text);
            speechSynthesis.onvoiceschanged = null;
        }
        return;
    }
    const utterance = new SpeechSynthesisUtterance(text);
    utterance.voice = speechSynthesis.getVoices().find(v => v.lang == 'fr-FR');
    window.speechSynthesis.speak(utterance);
};

