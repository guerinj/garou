<template>
    <div class="card">
        <div class="card-header">Qui est-tu ?</div>

        <div class="card-body">
            <ul class="list-unstyled">
                <li v-for="player in room.players" class="pb-2 mb-2 border-bottom">
                    <div class="d-flex">
                        <div :class="{ 'text-muted' : player.is_connected }">{{player.name}}</div>
                        <div class="ml-auto">
                            <button class="btn btn-success btn-sm"
                                    @click="joinAs(player.id)">Rejoindre
                            </button>
                            <span v-if="player.is_connected">Connecté</span>
                        </div>
                    </div>

                </li>
            </ul>
            <small v-if="hasError" class="text-danger">Une erreur est survenue, veuillez ré-essayer.</small>
        </div>
    </div>
</template>


<script>
    import {rolesHelper} from '../../helpers/roles';

    export default {
        props: {
            room: Object,
        },
        data() {
            return {
                hasError: false,
            }
        },

        methods: {
            rolesHelper,

            async joinAs(playerId) {
                this.hasError = false;
                try {
                    const {data} = await axios.post('/api/rooms/' + this.room.code + '/join/' + playerId);
                    this.$emit('player-selected', data);
                } catch {
                    console.log('Error while falling asleep');
                    this.hasError = true;
                    return;
                }
            },

        }
    }
</script>
