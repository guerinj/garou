<template>
    <div>
        <template v-if="room.step=='STEP_GAROU' && !done">
            <div class="card mb-2">
                <div class="card-body">
                    À ton tour Loup-Garou !
                </div>
            </div>
            <div class="card">
                <div class="card-body" v-if="otherGarou.length > 0 ">
                    Tes complices sont : {{otherGarou.join(', ')}}.
                </div>
                <div class="card-body" v-else>
                    Tu es tout seul ! Pour t'aider tu peux regarder une des cartes du milieu :
                    <ul class="list-unstyled">
                        <li v-for="index in [0, 1, 2]" class="pb-2 mb-2 border-bottom">
                            <div class="d-flex">
                                <div>Carte {{index+1}}</div>
                                <div class="ml-auto">
                                    <span v-if="freeCardIndex == index">
                                        {{rolesHelper(room.freeCards[index]).label}}
                                    </span>
                                    <button v-else-if="!freeCardIndex"
                                            class="btn btn-success btn-sm"
                                            @click="freeCardIndex = index">Voir
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
                freeCardIndex: null,
                hasError: false,
            }
        },
        computed: {
            otherGarou() {
                return this.room.players.filter(p => p.id != this.currentPlayer.id && p.original_role.includes('ROLE_GAROU'));
            }
        },
        methods: {
            getPlayer,
            rolesHelper,
        }
    }
</script>
