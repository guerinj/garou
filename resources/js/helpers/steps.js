export const stepHelper = (step) => {
    switch (step) {
        case 'STEP_GAROU' :
            return {
                start: 'Loup-Garou, réveillez-vous et regardez votre écran',
                end: 'Loup-Garou, rendormez-vous et fermez les yeux',
            };
            break;

        case 'STEP_VOYANTE' :
            return {
                start: 'Voyante, réveille-toi et regarde ton écran',
                end: 'Voyante, rendors-toi et ferme les yeux',
            };
            break;
        case 'STEP_NOISEUSE' :
            return {
                start: 'Noiseuse, réveille-toi et regarde ton écran',
                end: 'Noiseuse, rendors-toi et ferme les yeux',
            };
            break;
        case 'STEP_VOLEUR' :
            return {
                start: 'Voleur, réveille-toi et regarde ton écran',
                end: 'Voleur, rendors-toi et ferme les yeux',
            };
            break;

        case 'STEP_INSOMNIAQUE' :
            return {
                start: 'Insomniaque, réveille-toi et regarde ton écran',
                end: 'Insomniaque, rendors-toi et ferme les yeux',
            };
            break;

        case 'STEP_DAY' :
            return {
                start: 'Tout le village se réveille',
            };
            break;


    }
};
