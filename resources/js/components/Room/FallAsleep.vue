<template>
    <div v-if="!sleeping" class="text-center">
        <button @click="fallAsleep()" class="btn btn-success" :disabled="isBusy">
            Je m'endors
        </button>
        <div v-if="hasError" class="text-danger">
            <small>Une erreur est survenue, veuillez ré-essayer.
            </small>
        </div>
    </div>
    <div v-else class="text-center">
        Ferme les yeux et attends les instructions.
    </div>

</template>
<script>

    import {rolesHelper, getPlayer} from '../../helpers/roles';

    export default {
        props: {
            room: Object,
            currentPlayer: Object
        },
        data() {
            return {
                cardShown: false,
                hasError: false,
                isBusy: false,
                sleeping: false
            }
        },

        methods: {
            rolesHelper,
            getPlayer,

            async fallAsleep() {
                if (this.isBusy) {
                    return;
                }
                this.hasError = false;
                this.isBusy = true;
                try {
                    const {data} = await axios.post('/api/rooms/' + this.room.code + '/' + this.currentPlayer.id + '/sleep');
                    this.sleeping = true;
                } catch {
                    console.log('Error while falling asleep');
                    this.hasError = true;
                    this.isBusy = false;
                    return;
                }
            },


        }
    }
</script>
</script>
