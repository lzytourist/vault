<template>
    <v-app>
        <v-container>
            <h1 class="blue-grey--text">Notes</h1>
            <v-fab-transition>
                <v-btn
                    color="green"
                    dark
                    fixed
                    bottom
                    right
                    fab
                    class="elevation-1"
                    @click="toggleAddNote"
                >
                    <v-icon>fa fa-plus</v-icon>
                </v-btn>
            </v-fab-transition>
            <v-simple-table v-if="notes.length">
                <template v-slot:default>
                    <thead>
                    <tr>
                        <th class="text-left">#</th>
                        <th class="text-left">Note</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="note in notes" :key="note.id">
                        <td>{{ note.id }}</td>
                        <td>{{ note.note }}</td>
                        <td>
                            <v-btn
                                icon
                                color="deep-orange lighten-1"
                                @click="toggleAddNote(false, note)"
                            >
                                <v-icon>mdi-pencil</v-icon>
                            </v-btn>
                            <v-btn
                                icon
                                color="red"
                                @click="deleteNote(note, false)"
                            >
                                <v-icon>mdi-delete</v-icon>
                            </v-btn>
                        </td>
                    </tr>
                    </tbody>
                </template>
            </v-simple-table>
            <div class="text-center" v-if="total > 1">
                <v-pagination
                    v-model="page"
                    :length="total"
                    @input="getNotes"
                    color="deep-orange"
                ></v-pagination>
            </div>
            <NoContent v-if="!notes.length"/>
        </v-container>

        <!-- Show Dialog -->
        <v-dialog
            dark
            v-model="showNoteDialog"
            max-width="600"
        >
            <v-card>
                <v-card-title class="blue-grey--text"
            </v-card>
        </v-dialog>

        <!-- Add / Edit Dialog -->
        <v-dialog
            dark
            v-model="dialog"
            max-width="600"
        >
            <v-card>
                <v-card-title class="blue-grey--text" v-if="addNoteTitle">Add Note</v-card-title>
                <v-card-title class="blue-grey--text" v-if="!addNoteTitle">Edit Note</v-card-title>
                <v-card-text>
                    <v-form>
                        <v-text-field
                            label="Enter note"
                            v-model="note.note"></v-text-field>
                        <v-textarea
                            label="Enter note detail (optional)"
                            v-model="note.detail"></v-textarea>
                        <v-btn
                            outlined
                            color="blue"
                            @click="dialog = false">Cancel
                        </v-btn>
                        <v-btn
                            v-if="addNoteTitle"
                            outlined
                            color="green"
                            @click="addNote"
                        >Submit
                        </v-btn>
                        <v-btn
                            v-if="!addNoteTitle"
                            outlined
                            color="deep-orange accent-2"
                            @click="editNote"
                        >Update
                        </v-btn>
                    </v-form>
                </v-card-text>
            </v-card>
        </v-dialog>

        <!-- Delete Dialog -->
        <v-dialog
            dark
            v-model="deleteDialog"
            max-width="290"
        >
            <v-card>
                <v-card-title class="headline">
                    Are you sure?
                </v-card-title>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn
                        color="green darken-1"
                        text
                        @click="deleteDialog = false"
                    >
                        Cancel
                    </v-btn>

                    <v-btn
                        color="red darken-1"
                        text
                        @click="deleteNote(deleteNote, true)"
                    >
                        Delete
                    </v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
    </v-app>
</template>

<script>
import {mapMutations} from "vuex";
import NoContent from "../NoContent";

export default {
    name: "Note",
    components: {NoContent},
    data() {
        return {
            addNoteTitle: true,
            note: {
                id: null,
                note: null,
                detail: null
            },
            notes: [],
            total: 0,
            page: 1,
            config: {
                headers: {
                    'Content-Type': 'application/json',
                    'Authorization': 'Bearer ' + localStorage.getItem('user_token')
                }
            },
            dialog: false,
            deleteDialog: false,
            showNoteDialog: false
        }
    },
    methods: {
        ...mapMutations(["setSnackbar", "setProgressBar"]),
        getNotes() {
            this.setProgressBar(true);
            axios.get('/api/note?page=' + this.page, this.config).then(response => {
                this.notes = response.data.notes
                this.total = response.data.total
                this.setProgressBar(false);
            }).catch(error => {
                this.setProgressBar(false)
            })
        },

        toggleAddNote(addNote = true, note = null) {
            this.dialog = true;
            if (addNote) {
                this.addNoteTitle = true;
                this.note = {
                    note: null,
                    detail: null
                }
            } else {
                this.addNoteTitle = false;
                this.note = note;
            }
        },

        addNote() {
            this.setProgressBar(true)
            axios.get('/sanctum/csrf-cookie').then(response => {
                axios.post('/api/note', this.note, this.config).then(response => {
                    this.notes.pop();
                    this.notes.unshift(response.data.note);
                    this.setProgressBar(false);
                    this.setSnackbar(response.data.message);
                }).catch(error => {
                    this.setProgressBar(false);
                })
            })
        },

        editNote() {
            this.setProgressBar(true)
            axios.get('/sanctum/csrf-cookie').then(respone => {
                axios.patch('/api/note/' + this.note.id, this.note, this.config).then(response => {
                    this.setProgressBar(false)
                    this.setSnackbar(response.data.message)
                    this.dialog = false
                }).catch(error => {
                    this.setProgressBar(false)
                    this.setSnackbar(error.response.data.message)
                    this.dialog = false
                })
            })
        },

        deleteNote(note, confirmed) {
            if (!confirmed) {
                this.note = note;
                this.deleteDialog = true;
            } else {
                this.setProgressBar(true)
                axios.get('/sanctum/csrf-cookie').then(response => {
                    axios.delete('/api/note/' + this.note.id, this.config).then(response => {
                        this.notes.filter(no => (no.id !== note.id));
                        this.setSnackbar(response.data.message);
                        this.getNotes()
                        this.setProgressBar(false)
                    }).catch(error => {
                        this.setProgressBar(false);
                    })
                }).catch(error => {
                    this.setProgressBar(false)
                })

                this.deleteDialog = false;
            }
        },

        showNote() {

        }
    },
    created() {
        this.getNotes()
    }
}
</script>

<style scoped>
</style>
