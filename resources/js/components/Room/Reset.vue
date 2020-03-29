<template>
    <div class="text-center">
        <button @click="reset()" class="btn btn-success" :disabled="isBusy">
            Recommencer
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

            async reset() {
                if (this.isBusy) {
                    return;
                }
                this.hasError = false;
                this.isBusy = true;
                try {
                    const {data} = await axios.post('/api/rooms/' + this.room.code + '/reset');
                } catch {
                    console.log('Error while reset');
                    this.hasError = true;
                    this.isBusy = false;
                    return;
                }
            },


        }
    }
</script>
</script>
