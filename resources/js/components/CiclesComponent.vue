<template>
  <main>
    <div v-if="this.isError === true" class="alert alert-danger" role="alert">
      {{ errorMsg }}
    </div>
    <div class="card m-3">
      <div class="card-body">
        <h5 class="card-title">Cicles</h5>
        <table class="table table-striped">
          <thead>
            <tr>
              <th scope="col">Sigles</th>
              <th scope="col">Nom</th>
              <th scope="col">Descripcio</th>
              <th scope="col">Actiu</th>
              <th scope="col"></th>
            </tr>
          </thead>

          <tbody>
            <tr class="table-active" v-for="cicle in cicles" :key="cicle.id">
              <td class="col-1">
                {{ cicle.sigles }}
              </td>
              <td class="col-auto">
                {{ cicle.nom }}
              </td>
              <td class="col-auto">
                {{ cicle.descripcio }}
              </td>
              <td class="col-1">
                <input
                  class="form-check-input"
                  type="checkbox"
                  value="actiu"
                  name="actius[]"
                  :checked="cicle.actiu"
                  disabled
                />
              </td>
              <td class="col-auto">
                <div class="btn-group" role="group" aria-label="Basic example">
                  <button
                    type="button"
                    class="btn btn-sm btn-secondary"
                    @click="editCicle(cicle)"
                    data-bs-toggle="modal"
                    data-bs-target="#cicleModal"
                  >
                    <i class="fas fa-edit"></i>
                    Editar
                  </button>
                  <button
                    type="button"
                    class="btn btn-sm btn-danger"
                    @click="confirmdeleteCicle(cicle)"
                    data-bs-toggle="modal"
                    data-bs-target="#deleteModal"
                  >
                    <i class="fas fa-trash"></i>
                    Esborrar
                  </button>
                </div>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
      <button
        type="submit"
        class="btn btn-primary me-md-2"
        data-bs-toggle="modal"
        data-bs-target="#cicleModal"
        @click="createCicle()"
      >
        <i class="fas fa-plus-circle"></i>
        Nou curs
      </button>
    </div>

    <!-- Modal for delete -->
    <div class="modal" tabindex="-1" id="deleteModal" name="deleteModal">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Esborrar Cicle</h5>
            <button
              type="button"
              class="btn-close"
              data-bs-dismiss="modal"
              aria-label="Close"
            ></button>
          </div>
          <div class="modal-body">
            <p>Estas segur de que vols esborrar el curs {{ cicle.sigles }} ?</p>
          </div>
          <div class="modal-footer">
            <button
              type="button"
              class="btn btn-sm btn-secondary"
              data-bs-dismiss="modal"
            >
              Tancar
            </button>
            <button
              type="submit"
              id="deleteTrigg"
              class="btn btn-sm btn-primary"
              data-bs-dismiss="modal"
              @click="deleteCicle()"
            >
              Esborrar
            </button>
          </div>
        </div>
      </div>
    </div>

    <!-- Modal for insert/update -->
    <div class="modal" tabindex="-1" id="cicleModal" name="cicleModal">
      <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Cicle</h5>
            <button
              type="button"
              class="btn-close"
              data-bs-dismiss="modal"
              aria-label="Close"
            ></button>
          </div>
          <div class="modal-body">
            <form>
              <div class="row g-3 align-items-center mb-2">
                <div class="col-1">
                  <label for="sigles" class="col-form-label">Sigles</label>
                </div>
                <div class="col-10">
                  <input
                    type="text"
                    id="sigles"
                    class="form-control"
                    name="sigles"
                    v-model="cicle.sigles"
                  />
                </div>
              </div>
              <div class="row g-3 align-items-center mb-2">
                <div class="col-1">
                  <label for="nom" class="col-form-label">Nom</label>
                </div>
                <div class="col-10">
                  <input
                    type="text"
                    id="nom"
                    class="form-control"
                    name="nom"
                    v-model="cicle.nom"
                  />
                </div>
              </div>
              <div class="row g-3 align-items-center mb-2">
                <div class="col-1">
                  <label for="descripcio" class="col-form-label"
                    >Descripcio</label
                  >
                </div>
                <div class="col-10">
                  <select
                    v-model="cicle.descripcio"
                    class="form-select"
                    aria-label="Default select example"
                    id="descripcio"
                    name="descripcio"
                  >
                    <option v-for="cicle in cicles" :key="cicle.id">
                      {{ cicle.descripcio }}
                    </option>
                  </select>
                </div>
              </div>
              <div class="row g-3 align-items-center mb-2">
                <div class="col-1">
                  <label class="form-check-label" for="actiu">Actiu</label>
                </div>
                <div class="col-auto">
                  <input
                    type="checkbox"
                    class="form-check-input"
                    id="actiu"
                    v-model="cicle.actiu"
                    name="actiu"
                    checked
                  />
                </div>
              </div>
            </form>
          </div>
          <div class="modal-footer">
            <button
              type="button"
              class="btn btn-sm btn-secondary"
              data-bs-dismiss="modal"
            >
              Tancar
            </button>
            <button
              type="submit"
              class="btn btn-sm btn-primary"
              data-bs-dismiss="modal"
              @click="insertCicle()"
              v-if="insert"
            >
              Afegir
            </button>
            <button
              type="submit"
              class="btn btn-sm btn-primary"
              data-bs-dismiss="modal"
              @click="updateCicle()"
              v-else
            >
              Modificar
            </button>
          </div>
        </div>
      </div>
    </div>
  </main>
</template>

<script>
export default {
  data() {
    return {
      cicles: [],
      cicle: {
        id: "",
        sigles: "",
        nom: "",
        descripcio: "",
        actiu: false,
      },
      insert: true,
      infoMsg: "",
      errorMsg:"",
      isError: false,
    };
  },
  methods: {
    selectCicles() {
      let me = this;
      axios
        .get("/cicles")
        .then((response) => {
          me.cicles = response.data;
        })
        .catch((err) => {
          console.log(err);
        })
        .finally(() => (this.loading = false));
    },

    deleteCicle() {
      let me = this;
      axios
        .delete("/cicles/" + me.cicle.id)
        .then((response) => {
          me.infoMsg = response.data.mensaje;
          me.selectCicles();
        })
        .catch((error) => {
          this.errorMsg = error.response.data.error;
          this.isError = true;
        })
        .finally(() => (this.loading = false));
    },

    insertCicle() {
      let me = this;
      axios
        .post("/cicles", me.cicle)
        .then((response) => {
          console.log(response);
          me.selectCicles();
        })
        .catch((err) => {
          console.log(err);
        })
        .finally(() => (this.loading = false));
    },

    updateCicle() {
      let me = this;
      axios
        .put("/cicles/" + me.cicle.id, me.cicle)
        .then((response) => {
          console.log(response);
          me.selectCicles();
        })
        .catch((err) => {
          console.log(err.response.status);
        })
        .finally(() => (this.loading = false));
    },

    createCicle() {
      this.insert = true;
    },

    editCicle(cicle) {
      this.insert = false;
      this.cicle = cicle;
    },

    confirmdeleteCicle(cicle) {
      this.cicle = cicle;
    },
  },
  created() {
    this.selectCicles();
  },
  mounted() {
    console.log("Component mounted.");
  },
};
</script>
