<template>
    <div>
        <template v-if="room.step=='STEP_VOYANTE' && !done">
            <div class="card mb-2">
                <div class="card-body">
                    À ton tour Voyante !
                </div>
            </div>
            <div class="card">
                <div class="card-body" v-if="!voyanteChoiceValidated">
                    <b-form-group label="Que choisis-tu ? ">
                        <b-form-radio v-model="voyanteChoice" value="player">Voir la carte d'un joueur</b-form-radio>
                        <b-form-radio v-model="voyanteChoice" value="free">Voir deux des cartes restantes</b-form-radio>
                    </b-form-group>

                    <b-button variant="success" size="sm" @click="voyanteChoiceValidated=true">Valider</b-button>
                </div>

                <div class="card-body" v-else-if="voyanteChoice == 'player'">
                    <ul class="list-unstyled" v-if="!playerSeenId">
                        <li v-for="player in otherPlayers" class="pb-2 mb-2 border-bottom">
                            <div class="d-flex">
                                <div>{{player.name}}</div>
                                <div class="ml-auto">
                                    <button class="btn btn-success btn-sm"
                                            @click="seePlayer(player.id)">Voir
                                    </button>
                                </div>
                            </div>

                        </li>
                    </ul>
                    <p v-else="">
                        {{getPlayer(playerSeenId, room).name}} est <b>{{rolesHelper(getPlayer(playerSeenId,
                        room).current_role).label}}</b>

                        <b-button @click="done=true" variant="success">Je me rendors</b-button>
                    </p>
                </div>
                <div class="card-body" v-else-if="voyanteChoice == 'free'">
                    <ul class="list-unstyled">
                        <li v-for="index in [0, 1, 2]" class="pb-2 mb-2 border-bottom">
                            <div class="d-flex">
                                <div>Carte {{index+1}}</div>
                                <div class="ml-auto">
                                    <span v-if="freeCardSeenIndices.includes(index)">
                                        {{rolesHelper(room.freeCards[index]).label}}
                                    </span>
                                    <button v-else-if="freeCardSeenIndices.length < 2"
                                            class="btn btn-success btn-sm"
                                            @click="seeFreeCard(index)">Voir
                                    </button>
                                </div>
                            </div>

                        </li>
                    </ul>

                    <b-button @click="done=true" variant="success">Je me rendors</b-button>
                </div>
            </div>
        </template>
    </div>
</template>
<script>

    import {rolesHelper, getPlayer} from '../../../helpers/roles';

    export default {
        props: {
            room: Object,
            currentPlayer: Object
        },
        data() {
            return {
                done: false,
                voyanteChoiceValidated: false,
                voyanteChoice: null,
                playerSeenId: null,
                freeCardSeenIndices: [],
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
            seePlayer(playerId) {
                this.playerSeenId = playerId;
            },
            seeFreeCard(index) {
                if (this.freeCardSeenIndices.length < 2 && !this.freeCardSeenIndices.includes(index)) {
                    this.freeCardSeenIndices.push(index);
                }
            }
        }
    }
</script>
