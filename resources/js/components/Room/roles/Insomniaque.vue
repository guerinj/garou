<template>
    <div>
        <template v-if="room.step=='STEP_INSOMNIAQUE' && !done">
            <div class="card mb-2">
                <div class="card-body">
                    À ton tour Insomniaque !
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <p v-if="getPlayer(currentPlayer.id,room).current_role === getPlayer(currentPlayer.id,room).original_role">
                        Ton rôle n'a pas changé pendant la nuit, tu es toujours <b>
                        {{rolesHelper(getPlayer(currentPlayer.id,room).current_role).label}}
                    </b>
                    </p>
                    <p v-else>
                        Ton rôle a changé pendant la nuit, tu es désormais <b>
                        {{rolesHelper(getPlayer(currentPlayer.id,room).current_role).label}}
                    </b>
                    </p>


                    <b-button @click="done=true" variant="success">Je me rendors</b-button>
                </div>
            </div>
        </template>
    </div>
</template>
<script>

    import {rolesHelper, getPlayer} from '../../../helpers/roles';
    import FallAsleep from "../FallAsleep";

    export default {
        props: {
            room: Object,
            currentPlayer: Object
        },
        components: {FallAsleep},
        data() {
            return {
                done: false,
            }
        },
        methods: {
            getPlayer,
            rolesHelper,

        }
    }
</script>
