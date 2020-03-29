<template>

    <div class="card">
        <div class="card-header">
            Tu es connecté en tant que {{currentPlayer.name}} !
        </div>
        <div class="card-body">
            <template v-if="room.step === 'STEP_WAITING'">En attente des autres joueurs...</template>
            <template v-else-if="room.step === 'STEP_READY' && !cardShown">
                <p class="text-center">
                    <button @click="cardShown = true" class="btn btn-success">
                        Révéler la carte
                    </button>
                </p>
            </template>
            <template v-else-if="room.step === 'STEP_READY' && cardShown">
                <p>
                    Tu es
                    <b>{{rolesHelper(getPlayer(currentPlayer.id, room).original_role).label}}</b>.<br/>

                    <span v-html="roleDescription"/>
                    <br/>
                    <br/>
                    La nuit va bientôt commencer, ferme les yeux au début de la nuit et ouvre les
                    seulement
                    quand tu seras appelé. N’oublie pas de monter le son.<br/>
                    <br/>
                    Si vous êtes plusieurs dans la même pièce, mettez le son sur un seul appareil :)
                </p>
                <FallAsleep :room="room" :current-player="currentPlayer"></FallAsleep>
            </template>
        </div>
    </div>
</template>

<script>
    import {rolesHelper, getPlayer} from '../../helpers/roles';
    import FallAsleep from "./FallAsleep";

    export default {
        props: {
            room: Object,
            currentPlayer: Object
        },
        components: {FallAsleep},
        data() {
            return {
                cardShown: false,
            }
        },
        computed: {
            roleDescription() {
                const originalRole = getPlayer(this.currentPlayer.id, this.room).original_role;
                if (originalRole.includes('ROLE_GAROU')) {
                    const otherGarou = this.room.players.filter(p => p.id != this.currentPlayer.id && p.original_role.includes('ROLE_GAROU'));
                    if (otherGarou.length == 0) {
                        return 'Tu es le seul Loup-Garou.';
                    } else if (otherGarou.length == 1) {
                        return `Ton complice Loup-Garou est <b>${otherGarou[0].name}</b>.`;
                    } else {
                        return `Tes complices Loup-Garou s <b>${otherGaroumap(p => p.name).join(', ')}</b>.`;
                    }
                }
                if (originalRole == 'ROLE_SBIRE') {
                    const otherGarou = this.room.players.filter(p => p.id != this.currentPlayer.id && p.original_role.includes('ROLE_GAROU'));
                    if (otherGarou.length == 0) {
                        return "Tu n'as pas de complice Loug-Garou.";
                    } else if (otherGarou.length == 1) {
                        return `Ton complice Loup-Garou est <b>${otherGarou[0].name}</b>.`;
                    } else {
                        return `Tes complices Loup-Garou sont <b>${otherGarou.map(p => p.name).join(', ')}</b>.`;
                    }
                }
                if (originalRole.includes('ROLE_MACON')) {
                    const otherMacon = this.room.players.filter(p => p.id != this.currentPlayer.id && p.original_role.includes('ROLE_MACON'));
                    if (otherMacon.length == 0) {
                        return 'Tu es le seul Franc-Maçon.';
                    } else if (otherMacon.length == 1) {
                        return `Ton complice Franc-Maçon est <b>${otherMacon[0].name}</b>.`;
                    } else {
                        return `Tes complices Franc-Maçon sont <b>${otherMacon(p => p.name).join(', ')}</b>.`;
                    }
                }
            }
        },
        methods: {
            rolesHelper,
            getPlayer,
        }
    }
</script>
