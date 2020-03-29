export const rolesHelper = (role) => {
    switch (role) {
        case 'ROLE_GAROU1' :
        case 'ROLE_GAROU2' :
        case 'ROLE_GAROU3' :
            return {label: 'Loup-Garou'};
            break;
        case 'ROLE_VOYANTE' :
            return {label: 'Voyante'};
            break;
        case 'ROLE_NOISEUSE' :
            return {label: 'Noiseuse'};
            break;
        case 'ROLE_VOLEUR' :
            return {label: 'Voleur'};
            break;
        case 'ROLE_MACON1' :
        case 'ROLE_MACON2' :
            return {label: 'Franc-Maçon'};
            break;
        case 'ROLE_INSOMNIAQUE' :
            return {label: 'Insomniaque'};
            break;

        case 'ROLE_SBIRE' :
            return {label: 'Sbire'};
            break;


    }
};

export const getPlayer = (playerId, room) => {
    return room.players.find(p => p.id === playerId);
};
