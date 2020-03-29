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
        methods: {
            rolesHelper,
            getPlayer,
        }
    }
</script>
