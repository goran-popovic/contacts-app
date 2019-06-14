<template>
    <!--content-->
    <div class="content-holder">
        <div class="container">
            <form id="contacts-form" @submit.prevent="addContact" class="mb" enctype="multipart/form-data">
                <div class="form-group">
                    <label class="mb">Upload Avatar</label>
                    <input class="mb" type="file" id="avatar" ref="avatar" @change="handleFileUpload()"/>
                    <input type="text" class="form-control mb" placeholder="First Name"
                    v-model="contact.first_name">
                    <input type="text" class="form-control mb" placeholder="Last Name"
                           v-model="contact.last_name">
                    <div v-if="!edit">
                        <label class="mb">Choose a group or add your own bellow. When adding a new group enter the name of the group in the "Enter Group Name" field and click the Add group Button. After that select your group from dropdown. When deleting a group, first select it from dropdown and then click the Delete Group Button.</label>
                        <select class="form-control mb" v-model="contact.group_id">
                            <option v-for="group in groups" :value="group.id">
                                {{ group.name }}
                            </option>
                        </select>
                    </div>
                    <input type="text" class="form-control mb" placeholder="Enter Group Name"
                           v-model="group.name">
                    <a v-if="!edit" @click="deleteGroup(contact.group_id)" class="more fl mb">Delete Group</a>
                    <a v-if="!edit" @click="addGroup" class="more mb">Add Group</a>
                    <input type="text" class="form-control mb" placeholder="Address"
                           v-model="contact.address">
                    <input type="text" class="form-control mb" placeholder="City"
                           v-model="contact.city">
                    <input type="text" class="form-control mb" placeholder="Zip"
                           v-model="contact.zip">
                    <input type="text" class="form-control mb" placeholder="Country"
                           v-model="contact.country">
                    <input type="email" class="form-control mb" placeholder="Email"
                           v-model="contact.email">
                    <input type="text" class="form-control mb" placeholder="Phone"
                           v-model="contact.phone">
                    <textarea class="form-control mb" placeholder="Note"
                              v-model="contact.note">
                    </textarea>
                    <input type="hidden" class="form-control mb"
                           v-model="contact.group_id">
                </div>
                <button type="submit" class="more">Save</button>
            </form>
            <div class="single-inline mt-5">
                <div class="contact-to" v-for="contact in contacts" v-bind:key="contact.id">
                    <img class="img-responsive sin-on" :src="'/' + contact.avatar" alt="" />
                    <div class="contact-top">
                        <div class="contact-top-inner">
                            <p>First Name: {{ contact.first_name }}</p>
                            <p>Last Name: {{ contact.last_name }}</p>
                            <p>Group Name: {{ contact.group_name }}</p>
                            <p>Address: {{ contact.address }}</p>
                            <p>City: {{ contact.city }}</p>
                            <p>Zip: {{ contact.zip }}</p>
                            <p>Country: {{ contact.country }}</p>
                            <p>Email: {{ contact.email }}</p>
                            <p>Phone: {{ contact.phone }}</p>
                            <p>Note: {{ contact.note }}</p>
                            <div class="blog-buttons">
                                <a href="#" class="delete" @click.prevent="deleteContact(contact.id)">Delete<span> </span></a>
                                <a href="#" class="edit" @click.prevent="editContact(contact)">Edit<span> </span></a>
                            </div>
                        </div>
                        <div class="clearfix"> </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                contacts: [],
                groups: [],
                contact: {
                    id: '',
                    first_name: '',
                    last_name: '',
                    address: '',
                    city: '',
                    zip: '',
                    country: '',
                    email: '',
                    phone: '',
                    note: '',
                    group_id: '',
                    avatar: '',
                },
                group: {
                  id: '',
                  name: ''
                },
                contact_id: '',
                group_id: '',
                edit: false,
            }
        },
        created() {
            this.fetchGroups();
            this.fetchContacts();
        },
        methods: {
            handleFileUpload(){
                this.contact.avatar = this.$refs.avatar.files[0];
            },
            fetchContacts(page_url) {
                page_url = 'api/contacts';
                fetch(page_url)
                    .then(res => res.json())
                    .then(res => {
                        this.contacts = res.data;
                    })
                    .catch(err => console.log(err));
            },
            fetchGroups(page_url) {
                page_url = 'api/groups';
                fetch(page_url)
                    .then(res => res.json())
                    .then(res => {
                        this.groups = res.data;
                    })
                    .catch(err => console.log(err));
            },
            deleteContact(id) {
                if(confirm('Are you sure?')) {
                    fetch(`/api/contact/${id}`, {
                        method: 'DELETE'
                    })
                        .then(res => res.json())
                .then(data => {
                        alert('Contact Removed');
                    this.fetchContacts();
                })
                .catch(err => console.log(err));
                }
            },
            deleteGroup(id) {
                if(confirm('Are you sure?')) {
                    fetch(`/api/group/${id}`, {
                        method: 'DELETE'
                    })
                        .then(res => res.json())
                .then(data => {
                        alert('Group Removed');
                    this.fetchGroups();
                })
                .catch(err => console.log(err));
                }
            },
            addContact() {
                if(this.edit === false) {
                    // Add
                    let formData = new FormData();
                    formData.append('id', this.contact.id);
                    formData.append('first_name', this.contact.first_name);
                    formData.append('last_name', this.contact.last_name);
                    formData.append('address', this.contact.address);
                    formData.append('city', this.contact.city);
                    formData.append('zip', this.contact.zip);
                    formData.append('country', this.contact.country);
                    formData.append('email', this.contact.email);
                    formData.append('phone', this.contact.phone);
                    formData.append('note', this.contact.note);
                    formData.append('group_id', this.contact.group_id);
                    formData.append('avatar', this.contact.avatar);
                    fetch('api/contact', {
                        method: 'POST',
                        body: formData,
                    })
                        .then(res => res.json())
                        .then(data => {
                            this.contact.first_name = '';
                            this.contact.last_name = '';
                            this.contact.address = '';
                            this.contact.city = '';
                            this.contact.zip = '';
                            this.contact.country = '';
                            this.contact.email = '';
                            this.contact.phone = '';
                            this.contact.note = '';
                            this.contact.group_id = '';
                            this.contact.avatar = '';
                            alert('Contact Added');
                            this.fetchContacts();
                        })
                        .catch(err => console.log(err));
                } else {
                    // Update
                    this.addGroup();
                    let formData = new FormData();
                    formData.append('id', this.contact.id);
                    formData.append('first_name', this.contact.first_name);
                    formData.append('last_name', this.contact.last_name);
                    formData.append('address', this.contact.address);
                    formData.append('city', this.contact.city);
                    formData.append('zip', this.contact.zip);
                    formData.append('country', this.contact.country);
                    formData.append('email', this.contact.email);
                    formData.append('phone', this.contact.phone);
                    formData.append('note', this.contact.note);
                    formData.append('group_id', this.contact.group_id);
                    formData.append('avatar', this.contact.avatar);
                    formData.append('contact_id', this.contact.contact_id);
                    formData.append('_method', 'PUT');
                    fetch('api/contact', {
                        method: 'POST',
                        body: formData,
                    })
                        .then(res => res.json())
                        .then(data => {
                            this.contact.first_name = '';
                            this.contact.last_name = '';
                            this.contact.address = '';
                            this.contact.city = '';
                            this.contact.zip = '';
                            this.contact.country = '';
                            this.contact.email = '';
                            this.contact.phone = '';
                            this.contact.note = '';
                            this.contact.group_id = '';
                            this.contact.avatar = '';
                            alert('Contact Updated');
                            this.edit = false;
                            this.fetchContacts();
                            this.fetchGroups();
                        })
                        .catch(err => console.log(err));
                }
            },
            addGroup() {
                if(this.edit === false) {
                    // Add
                    fetch('api/group', {
                        method: 'post',
                        body: JSON.stringify(this.group),
                        headers: {
                            'content-type': 'application/json'
                        }
                    })
                        .then(res => res.json())
                        .then(data => {
                            this.group.name = '';
                            alert('Group Added. Please select it from dropdown.');
                            this.fetchGroups();
                        })
                        .catch(err => console.log(err));
                } else {
                    // Update
                    fetch('api/group', {
                        method: 'put',
                        body: JSON.stringify(this.group),
                        headers: {
                            'content-type': 'application/json'
                        }
                    })
                        .then(res => res.json())
                        .then(data => {
                            this.group.id = '';
                            this.group.name = '';
                        })
                        .catch(err => console.log(err));
                }
            },
            editContact(contact) {
                this.scrollToForm();

                this.edit = true;
                this.contact.id = contact.id;
                this.contact.contact_id = contact.id;
                this.contact.first_name = contact.first_name;
                this.contact.last_name = contact.last_name;
                this.contact.address = contact.address;
                this.contact.city = contact.city;
                this.contact.zip = contact.zip;
                this.contact.country = contact.country;
                this.contact.email = contact.email;
                this.contact.phone = contact.phone;
                this.contact.note = contact.note;
                this.contact.group_id = contact.group_id;
                this.group.id = contact.group_id;
                this.group.name = contact.group_name;
                this.contact.avatar = contact.avatar;
            },
            scrollToForm() {
                let contacts_form = this.$el.querySelector("#contacts-form");
                contacts_form.scrollIntoView();
            }
        },
    }

</script>