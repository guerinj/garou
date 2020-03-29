<template>
    <div class="card-body">
        <p>
            C’est le jour ! Vous pouvez maintenant discuter et voter pour éliminer un joueur.
        </p>
        <p v-if="!displayRoles" class="text-center">
            <b-button variant="success" @click="displayRoles=true">Révéler les rôles</b-button>
        </p>

        <template v-else>
            <ul class="list-unstyled">
                <li v-for="player in room.players">
                    {{player.name}} est <b>{{rolesHelper(player.current_role).label}}</b>.
                </li>
            </ul>

            <Reset :room="room"/>
        </template>
    </div>
</template>
<script>
    import {rolesHelper, getPlayer} from '../../helpers/roles';
    import Reset from "./Reset";

    export default {
        components: {Reset},
        props: {
            room: Object,

        },
        data() {
            return {displayRoles: false};
        },
        methods: {
            rolesHelper,
            getPlayer,
        }
    }

</script>
