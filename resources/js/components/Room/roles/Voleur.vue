<template>
    <div>
        <template v-if="room.step=='STEP_VOLEUR' && !done">
            <div class="card mb-2">
                <div class="card-body">
                    À ton tour Voleur !<br/>
                    <br/>
                    Choisis ci-dessous la personne à qui tu veux voler la carte.
                </div>
            </div>
            <div class="card">
                <div class="card-body" v-if="!stealedPlayer">
                    <ul class="list-unstyled">
                        <li v-for="player in otherPlayers" class="pb-2 mb-2 border-bottom">
                            <div class="d-flex">
                                <div>{{player.name}}</div>
                                <div class="ml-auto">
                                    <button class="btn btn-success btn-sm"
                                            @click="steal(player.id)">Voler
                                    </button>
                                </div>
                            </div>

                        </li>
                    </ul>
                    <div v-if="hasError" class="text-danger">
                        <small>Une erreur est survenue, veuillez ré-essayer.
                        </small>
                    </div>
                </div>
                <div class="card-body" v-else>
                    <p>
                        Tu as volé {{stealedPlayer.name}}.<br/>
                        {{stealedPlayer.name}} était {{rolesHelper(stealedPlayer.original_role).label}}.<br/>
                        Tu es désormais {{rolesHelper(stealedPlayer.original_role).label}} et {{stealedPlayer.name}} est
                        {{rolesHelper(getPlayer(currentPlayer.id, room).original_role).label}}.
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
                stealedPlayer: null,
                cardShown: false,
                hasError: false,
            }
        },
        computed: {
            otherPlayers() {
                return this.room.players.filter(p => p.id != this.currentPlayer.id);
            }
        },
        methods: {
            getPlayer,
            rolesHelper,
            async steal(otherPlayerId) {
                this.hasError = false;
                try {
                    const {data} = await axios.post('/api/rooms/' + this.room.code + '/' + this.currentPlayer.id + '/action', {
                        role: 'ROLE_VOLEUR',
                        stealedPlayerId: otherPlayerId
                    });

                    this.stealedPlayer = getPlayer(otherPlayerId, this.room);
                } catch {
                    console.log('Error while stealing card');
                    this.hasError = true;
                    return;
                }

            },
        }
    }
</script>
