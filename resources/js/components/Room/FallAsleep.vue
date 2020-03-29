<template>
    <div class="text-center">
        <button @click="fallAsleep()" class="btn btn-success" :disabled="isBusy">
            Je m'endors
        </button>
        <div v-if="hasError" class="text-danger">
            <small>Une erreur est survenue, veuillez ré-essayer.
            </small>
        </div>
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
