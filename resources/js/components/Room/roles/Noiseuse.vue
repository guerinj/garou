<template>
    <div>
        <template v-if="room.step=='STEP_NOISEUSE' && !done">
            <div class="card mb-2">
                <div class="card-body">
                    À ton tour Noiseuse !
                </div>
            </div>
            <div class="card">
                <div class="card-body" v-if="!validated">
                    <b-form-group label="Choisis les deux personnes dont tu veux échanger les cartes :">
                        <b-form-checkbox
                            v-for="player in otherPlayers"
                            :value="player.id"
                            :key="player.id"
                            v-model="selectedPlayerIds"
                            :disabled="selectedPlayerIds.length == 2 && !selectedPlayerIds.includes(player.id)"
                        >
                            {{player.name}}
                        </b-form-checkbox>
                    </b-form-group>
                    <b-button variant="success" @click="noise()">Valider</b-button>

                    <div v-if="hasError" class="text-danger">
                        <small>Une erreur est survenue, veuillez ré-essayer.
                        </small>
                    </div>
                </div>
                <div class="card-body" v-else>
                    <p>
                        Tu as échangés les cartes de <b>{{getPlayer(selectedPlayerIds[0], room).name}}</b> et
                        <b>{{getPlayer(selectedPlayerIds[1], room).name}}</b>.
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
                selectedPlayerIds: [],
                validated: false,
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
            async noise() {
                const [player1Id, player2Id] = this.selectedPlayerIds;
                this.hasError = false;
                try {
                    const {data} = await axios.post('/api/rooms/' + this.room.code + '/' + this.currentPlayer.id + '/action', {
                        role: 'ROLE_NOISEUSE',
                        player1Id,
                        player2Id,
                    });

                    this.validated = true;
                } catch {
                    console.log('Error while noising cards');
                    this.hasError = true;
                    return;
                }

            },
        }
    }
</script>
