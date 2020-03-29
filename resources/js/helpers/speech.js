export const sayThis = (text) => {
    if(!text) return;
    const utterance = new SpeechSynthesisUtterance(text);
    utterance.voice = speechSynthesis.getVoices().find(v => v.lang == 'fr-FR');
    speechSynthesis.speak(utterance);
}

