<template>
  <v-container>
    <v-card>
      <v-card-title>
        <h2>Gestión de Tareas</h2>
      </v-card-title>
      <v-card-text>
        <div class="search-fields">
          <div class="search-field">
            <label for="buscaCampo">Buscar Campo:</label>
            <select v-model="buscaCampo" id="buscaCampo">
              <option value="nombre">Nombre</option>
              <option value="descripcion">Descripción</option>
              <option value="user.name">Usuario asignado</option>
            </select>
          </div>

          <div class="search-field">
            <label for="buscaValor">Buscar Valor:</label>
            <input type="text" v-model="buscaValor" id="buscaValor" />
          </div>
        </div>

        <v-btn @click="openCreateTareaForm" class="create-task-button" color="primary">
          <v-icon left>
            mdi-plus
          </v-icon>
          <v-tooltip activator="parent" location="start">Agregar Nueva Tarea
          </v-tooltip>
        </v-btn>
        <EasyDataTable :headers="tableHeaders" :items="tareas" buttons-pagination :search-field="buscaCampo"
          :search-value="buscaValor" :rows-per-page="10" :rows-items="[10, 15]" rows-per-page-message="Filas por página"
          border-cell>
          <template #item-tarea.id="item">
            <v-tooltip text="Ver Tarea">
              <template v-slot:activator="{ props }">
                <v-icon v-bind="props" @click="mostrarTarea(item.id)" color="primary" class="action-icon">mdi-eye</v-icon>
              </template>
            </v-tooltip>

            <v-tooltip text="Suprimir Tarea">
              <template v-slot:activator="{ props }">
                <v-icon v-bind="props" @click="showDeleteConfirmation(item.id)" color="error"
                  class="action-icon">mdi-delete</v-icon>
              </template>
            </v-tooltip>

            <v-tooltip text="Marcar Tarea como Completada" v-if="!item.completada">
              <template v-slot:activator="{ props }">
                <v-icon v-bind="props" v-if="!item.completada" @click="marcarTareaCompletada(item.id)" color="success"
                  class="action-icon"> mdi-check</v-icon>
              </template>
            </v-tooltip>
          </template>

          <template #item-tarea.completada="item">

            <v-icon v-if="item.completada === 1" color="success" class="action-icon">
              mdi-check
            </v-icon>
            <span v-if="item.completada === 1">Si</span>

            <v-icon v-if="item.completada === 0" color="error" class="action-icon">
              mdi-close
            </v-icon>
            <span v-if="item.completada === 0">No</span>
          </template>
        </EasyDataTable>
      </v-card-text>
    </v-card>


    <v-dialog v-model="showDetallesTarea" max-width="800px">
      <v-card class="details-dialog">
        <v-card-title>
          <h2>Detalles de Tarea</h2>
        </v-card-title>
        <v-card-text>
          <div class="detail-section">
            <strong>Nombre:</strong> {{ tareaSeleccionada.nombre }}
          </div>
          <div class="detail-section">
            <strong>Descripción:</strong> {{ tareaSeleccionada.descripcion }}
          </div>
          <div class="detail-section">
            <strong>Fecha Límite:</strong> {{ tareaSeleccionada.fecha_tarea }}
          </div>

          <div class="detail-section">
            <strong>Categorías:</strong>
            <ul class="categoria-list">
              <li v-for="categoria in tareaSeleccionada.categorias" :key="categoria.id" class="categoria-item">
                {{ categoria.nombre }}
              </li>
            </ul>
          </div>
          <div class="detail-section">
            <strong>Usuario asignado:</strong> {{ tareaSeleccionada.user.name }}
          </div>
        </v-card-text>
      </v-card>
    </v-dialog>

    <v-dialog v-model="showCreateForm" max-width="600px">
      <v-card>
        <v-card-title>
          <h2>Nueva Tarea</h2>
        </v-card-title>
        <v-card-text>
          <v-form ref="tareaForm" @submit.prevent="createTarea">
            <v-text-field v-model="newTarea.nombre" label="Nombre" required :error-messages="nombreErrors"></v-text-field>
            <v-textarea v-model="newTarea.descripcion" label="Descripción" required
              :error-messages="descripcionErrors"></v-textarea>
            <Multiselect v-model="categorias_id" label="nombre" mode="tags" value-prop="id" :close-on-select="false"
              :searchable="true" :create-option="true" :options="categorias"
              placeholder="Elige una categoría (opcional)" />
            <div class="datepicker-container">
              <label>Selecciona una fecha</label>
              <datepicker v-model="picked" inputFormat="dd-MM-yyyy" :locale="dateLocale" required
                :error-messages="fechaErrors" class="custom-datepicker">
              </datepicker>
            </div>
          </v-form>
        </v-card-text>
        <v-card-actions>
          <v-btn @click="createTarea" class="create-btn">Crear</v-btn>
          <v-btn @click="closeCreateForm" color="error">Cancelar</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>

    <v-dialog v-model="showDeleteDialog" max-width="400px">
      <v-card>
        <v-card-title class="delete-dialog-title">
          Confirmar Eliminación
          <v-icon @click="cancelDelete" class="dialog-close-icon">mdi-close</v-icon>
        </v-card-title>
        <v-card-text>
          ¿Estás seguro de que quieres eliminar la tarea?
        </v-card-text>
        <v-card-actions class="delete-dialog-actions">
          <v-btn @click="cancelDelete" color="primary" class="cancel-btn">Cancelar</v-btn>
          <v-btn @click="deleteTarea(selectedTaskId)" class="delete-btn">Eliminar</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>

  </v-container>
</template>

<script>
import axios from 'axios';
import Multiselect from '@vueform/multiselect';
import Datepicker from 'vue3-datepicker';
import es from 'date-fns/locale/es';
import { toast } from 'vue3-toastify';
import 'vue3-toastify/dist/index.css';
import Popper from "vue3-popper";
import { VTooltip } from 'v-tooltip';

export default {
  components: {
    Multiselect,
    Datepicker,
  },
  data() {
    return {
      tableHeaders: [
        { text: 'Nombre', value: 'nombre' },
        { text: 'Descripción', value: 'descripcion' },
        { text: 'Fecha Límite', value: 'fecha_tarea' },
        { text: 'Usuario asignado', value: 'user.name' },
        { text: 'Categorias', value: 'categorias_tarea', sortable: false },
        { text: 'Completada', value: 'tarea.completada', sortable: true },
        { text: "Acciones", value: "tarea.id", sortable: true },
      ],

      tareas: [],
      categorias: [],
      categorias_id: [],
      categorias_tarea: [],
      showCreateForm: false,
      newTarea: {
        nombre: '',
        descripcion: '',
        fecha_tarea: '',
        categorias_id: [],
        completada: false,
      },
      users: [],
      selectedItems: [],
      picked: new Date(),
      dateLocale: es,
      nombreErrors: [],
      descripcionErrors: [],
      fechaErrors: [],
      buscaCampo: "nombre",
      buscaValor: "",
      showDetallesTarea: false,
      tareaSeleccionada: null,
      showDeleteDialog: false,
      selectedTaskId: null,
    };
  },
  mounted() {
    this.fetchCategorias();
    this.fetchTareas();

  },
  methods: {

    fetchCategorias() {

      axios
        .get('/api/categorias')
        .then(response => {
          this.categorias = response.data;
        })
        .catch(error => {
          console.error('Error fetching categorias:', error);
        });
    },
    fetchTareas() {
      axios
        .get('/api/tareas')
        .then(response => {
          this.tareas = response.data;
          this.tareas.forEach(tarea => {
            tarea.categorias_tarea = tarea.categorias.map(categoria => categoria.nombre);
          });
        })
        .catch(error => {
          toast.error("Error al mostrar los datos de las tareas", {
            position: toast.POSITION.TOP_LEFT,
          });
        });
    },
    mostrarTarea(id) {
      axios
        .get(`/api/tareas/${id}`)
        .then(response => {
          this.tareaSeleccionada = response.data;
          this.showDetallesTarea = true;
        })
        .catch(error => {
          toast.error("Error al mostrar los datos de la tarea", {
            position: toast.POSITION.TOP_LEFT,
          });
        });
    },
    cerrarMostrarTarea() {
      this.showDetallesTarea = false;
      this.tareaSeleccionada = null;
    },

    showDeleteConfirmation(taskId) {
      this.selectedTaskId = taskId;
      this.showDeleteDialog = true;
    },

    cancelDelete() {
      this.selectedTaskId = null;
      this.showDeleteDialog = false;
    },

    deleteTarea(id) {
      const tareaId = id;
      axios
        .delete(`/api/tareas/${tareaId}`)
        .then(response => {
          toast.success(response.data.message, {
            position: toast.POSITION.TOP_CENTER,
          });
          this.fetchTareas();
          this.showDeleteDialog = false;
        })
        .catch(error => {
          toast.error("Error al intentar eliminar la tarea", {
            position: toast.POSITION.TOP_LEFT,
          });
        });
    },

    openCreateTareaForm() {
      this.showCreateForm = true;
    },
    closeCreateForm() {
      this.showCreateForm = false;
      this.newTarea = {
        nombre: '',
        descripcion: '',
        fecha_tarea: '',
        categorias_id: [],
      };
      this.nombreErrors = [];
      this.descripcionErrors = [];
      this.fechaErrors = [];
    },
    createTarea() {
      this.nombreErrors = this.validaNombre();
      this.descripcionErrors = this.validaDescripcion();
      this.fechaErrors = this.validaFecha();
      this.newTarea.fecha_tarea = this.picked;
      this.newTarea.categorias_id = this.categorias_id;

      if (
        this.nombreErrors.length === 0 &&
        this.descripcionErrors.length === 0 &&
        this.fechaErrors.length === 0
      ) {
        axios
          .post('/api/tareas', this.newTarea)
          .then(response => {
            toast.success("Se ha creado una tarea correctamente", {
              position: toast.POSITION.TOP_CENTER,
            });
            this.closeCreateForm();
            this.fetchTareas();
          })
          .catch(error => {
            toast.error("Error al crear la tarea!", {
              position: toast.POSITION.TOP_CENTER,
            });
          });
      } else {
        toast.error("Por favor, completa todos los campos requeridos", {
          position: toast.POSITION.TOP_CENTER,
        });
      }
    },
    validaNombre() {
      const errors = [];
      if (!this.newTarea.nombre) {
        errors.push('El nombre es necesario');
      }
      return errors;
    },
    validaDescripcion() {
      const errors = [];
      if (!this.newTarea.descripcion) {
        errors.push('La descripción es necesaria');
      }
      return errors;
    },
    validaFecha() {
      const errors = [];
      if (!this.picked) {
        errors.push('La fecha es necesaria');
      }
      return errors;
    },
    marcarTareaCompletada(id) {
      const tarea = this.tareas.find(t => t.id === id);
      if (tarea) {
        tarea.completada = true;
        axios
          .put(`/api/tareas/${id}/mark-as-completed`, tarea)
          .then(response => {
            toast.success("Se ha marcado la tarea como completada", {
              position: toast.POSITION.TOP_CENTER,
            });
            this.fetchTareas();
          })
          .catch(error => {
            toast.error("Error al marcar como completada la tarea", {
              position: toast.POSITION.TOP_LEFT,
            });
          });
      }
    },

  },
};
</script>

<style src="@vueform/multiselect/themes/default.css"></style>


