<template>
    <div class="container">
        <div class="row justify-content-center mt-4">
            <div class="col-12 col-md-8 col-lg-6">
                <template v-if="currentPlayer">

                    <RoleDistribution v-if="room.step === 'STEP_WAITING' || room.step=== 'STEP_READY'"
                                      :room="room"
                                      :current-player="currentPlayer"
                    >
                    </RoleDistribution>
                    <div class="card mb-2" v-else-if="room.step !== 'STEP_DAY'">
                        <div class="card-body">
                            C’est la nuit ! Ferme les yeux. Ouvre les quand la voix t’appelle.
                        </div>
                    </div>
                    <div class="card mb-2" v-else>
                        <Day :room="room"/>
                    </div>

                    <Garou
                            v-if="getPlayer(currentPlayer.id, room).original_role === 'ROLE_GAROU'"
                            :room="room"
                            :current-player="currentPlayer"/>
                    <Voyante
                            v-if="getPlayer(currentPlayer.id, room).original_role === 'ROLE_VOYANTE'"
                            :room="room"
                            :current-player="currentPlayer"/>

                    <Voleur
                            v-if="getPlayer(currentPlayer.id, room).original_role === 'ROLE_VOLEUR'"
                            :room="room"
                            :current-player="currentPlayer"/>

                    <Noiseuse
                            v-if="getPlayer(currentPlayer.id, room).original_role === 'ROLE_NOISEUSE'"
                            :room="room"
                            :current-player="currentPlayer"/>
                    <Insomniaque
                            v-if="getPlayer(currentPlayer.id, room).original_role === 'ROLE_INSOMNIAQUE'"
                            :room="room"
                            :current-player="currentPlayer"/>
                </template>


                <template v-else-if="room" class="col-md-8">
                    <PlayerSelection :room="room" @player-selected="joinRoom">
                    </PlayerSelection>
                </template>

                <div class="card mt-3">
                    <div class="card-body">
                        <p>Pour rappel voici la liste des personnages de cette partie :</p>
                        <ul>
                            <li v-for="role in room.roles">{{rolesHelper(role).label}}</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

    import {rolesHelper, getPlayer} from '../../helpers/roles';
    import RoleDistribution from "./RoleDistribution";
    import PlayerSelection from "./PlayerSelection";
    import Voleur from "./roles/Voleur";
    import Voyante from "./roles/Voyante";
    import Noiseuse from "./roles/Noiseuse";
    import Insomniaque from "./roles/Insomniaque";
    import Garou from "./roles/Garou";
    import {sayThis} from "../../helpers/speech";
    import {stepHelper} from "../../helpers/steps";
    import Reset from "./Reset";
    import Day from "./Day";

    const stepDuration = 20000;
    const stepInterval = 5000;
    export default {
        props: {
            roomCode: String
        },
        components: {Reset, Day, Insomniaque, RoleDistribution, PlayerSelection, Voleur, Voyante, Noiseuse, Garou},
        data() {
            return {
                room: null,
                currentPlayer: null,
            }
        },
        async mounted() {
            const {data} = await axios.get('/api/rooms/' + this.roomCode);
            this.room = data.data;

            window.Echo
                .channel('room.' + this.roomCode)
                .listen('RoomUpdated', (room) => {
                    const oldStep = this.room.step;
                    this.room = room;

                    if (oldStep != room.step) {
                        const delay = Date.now() / 1000 - room.step_started_at;
                        console.log(delay);
                        setTimeout(() => {
                            sayThis(stepHelper(room.step).start)
                        }, stepInterval / 2 - delay);

                        setTimeout(() => {
                            sayThis(stepHelper(room.step).end)
                        }, stepDuration - stepInterval / 2 - delay);
                    }
                });
        },
        methods: {
            rolesHelper,
            getPlayer,
            joinRoom({user, room}) {

                this.currentPlayer = user;
                this.room = room;


            }
        }
    }
</script>
