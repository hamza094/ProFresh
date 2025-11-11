<template>
  <div>
    <div class="row mt-3 mb-5">
      <div class="col-md-6">
        <div class="card">
          <div class="card-header">Roles</div>
          <div class="card-body">
            Add New Role
            <div class="ms-2 d-inline-block">
              <input
                type="text"
                class="form-control form-control-sm"
                name="role"
                v-model="form.role"
                autocomplete="off"
                @keyup.enter="addNewRole()" />
            </div>
            <span class="text-danger font-italic" v-if="errors.name" v-text="errors.name[0]"></span>
            <div class="mt-3">
              <div v-for="role in roles" :key="role.id" class="role-container">
                <div class="role-content">
                  <p>{{ role.name }}</p>
                  <div class="button-group">
                    <div v-if="role.permissions.length > 0" class="role-dropdown" @click="toggleDropdown(role.id)">
                      <span class="btn btn-sm btn-primary" role="button">+</span>
                      <div class="role-dropdown_item" v-show="isOpen[role.id]">
                        <div class="role-dropdown_content">
                          <ul
                            class="role-list"
                            v-for="permission in role.permissions"
                            :key="permission.id || permission.name">
                            <li class="role-list_items">
                              {{ permission.name }}
                              <span @click.prevent="unAssignPermission(permission.id, role.id)" class="cursor"
                                ><i class="fa-solid fa-minus-circle"></i
                              ></span>
                            </li>
                          </ul>
                        </div>
                      </div>
                    </div>
                    <button class="btn btn-sm btn-danger" @click="removeRole(role.id)">Delete</button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="card">
          <div class="card-header">Permissions</div>
          <div class="card-body">
            Add New Permission
            <div class="ms-2 d-inline-block">
              <input
                type="text"
                class="form-control form-control-sm"
                name="role"
                v-model="form.permission"
                autocomplete="off"
                @keyup.enter="addPermission()" />
            </div>
            <div class="mt-3">
              <div v-for="permission in permissions" :key="permission.id">
                <div class="dropdown">
                  <span>{{ permission.name }}</span>
                  <a
                    class="dropdown-toggle text-secondary"
                    href="#"
                    data-bs-toggle="dropdown"
                    aria-haspopup="true"
                    aria-expanded="false"
                    >Assign to role</a
                  >
                  <div class="dropdown-menu dropdown-menu-end">
                    <a
                      v-for="role in roles"
                      :key="role.id"
                      class="dropdown-item"
                      @click="assignPermissionRole(permission.id, role.id)">
                      {{ role.name }}
                    </a>
                  </div>
                  <span class="float-right">
                    <button class="btn btn-sm btn-danger" @click="removePermission(permission.id)">Delete</button>
                  </span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { mapMutations, mapActions, mapState } from 'vuex';
export default {
  data() {
    return {
      form: {
        role: '',
        permission: '',
      },
      errors: {},
      permissions: [],
      isOpen: {},
      isPop: false,
    };
  },
  computed: {
    ...mapState('roles', ['roles']),
  },
  watch: {
    isPop(isPop) {
      if (isPop) {
        document.addEventListener('click', (event) =>
          this.$options.methods.handleClickOutside.call(this, event, '.role-dropdown', this.isPop),
        );
      }
    },
  },
  mounted() {
    this.loadRoles();
    this.loadPermissions();
  },
  methods: {
    ...mapActions({
      loadRoles: 'roles/loadRoles',
    }),

    ...mapMutations('roles', ['setRoles', 'addRole', 'roleDelete', 'roleUpdate']),

    toggleDropdown(roleId) {
      this.isOpen = {
        ...this.isOpen,
        [roleId]: !this.isOpen[roleId],
      };
    },

    addPermission() {
      axios
        .post('/api/v1/admin/permissions', {
          permission: this.form.permission,
        })
        .then((response) => {
          this.$vToastify.success(response.data.message);
          this.form.permission = '';
          this.loadPermissions();
        })
        .catch((error) => {
          console.log(error);
        });
    },

    addNewRole() {
      axios
        .post('/api/v1/admin/roles', { name: this.form.role })
        .then((response) => {
          this.addRole(response.data.role);
          this.$vToastify.success(response.data.message);
          this.form.role = '';
          this.errors = {};
        })
        .catch((error) => {
          if (error.response.status === 422) {
            this.errors = error.response.data.errors;
          } else {
            this.$vToastify.warning('Error! Contact Admin support');
          }
        });
    },

    removeRole(roleId) {
      axios
        .delete('/api/v1/admin/roles/' + roleId)
        .then(() => {
          this.$vToastify.success('Permission Deleted Successfully');
          this.roleDelete(roleId);
        })
        .catch(() => {
          this.$vToastify.warning('Error! Contact Admin support');
        });
    },

    removePermission(permissionId) {
      axios
        .delete('/api/v1/admin/permissions/' + permissionId)
        .then(() => {
          this.$vToastify.success('Permission Deleted Successfully');
          this.loadPermissions();
        })
        .catch(() => {
          this.$vToastify.warning('Error! Contact Admin support');
        });
    },

    assignPermissionRole(permissionId, roleId) {
      axios
        .get('/api/v1/admin/assign/roles/' + roleId + '/permissions/' + permissionId)
        .then((response) => {
          this.$vToastify.success(response.data.message);
          this.roleUpdate(response.data.role);
        })
        .catch((error) => {
          if (error.response.status === 422) {
            this.$vToastify.warning(error.response.data.errors.permission[0]);
          } else {
            this.$vToastify.warning('Error! Contact Admin support');
          }
        });
    },

    unAssignPermission(permissionId, roleId) {
      axios
        .get('/api/v1/admin/unAssign/roles/' + roleId + '/permissions/' + permissionId)
        .then((response) => {
          this.$vToastify.success(response.data.message);
          this.roleUpdate(response.data.role);
        })
        .catch((error) => {
          if (error.response.status === 422) {
            this.$vToastify.warning(error.response.data.errors.permission[0]);
          } else {
            this.$vToastify.warning('Error! Contact Admin support');
          }
        });
    },

    loadPermissions() {
      axios
        .get('/api/v1/admin/permissions')
        .then((response) => {
          this.permissions = response.data;
        })
        .catch(() => {
          this.$vToastify.warning('Error! Contact Admin support');
        });
    },
  },
};
</script>
