<template>
    <div class="login-container">
        <div class="common-card-large">
            <h1 class="common-title-large">
                {{ isEditing ? 'Editing a recipe' : 'New recipe' }}
            </h1>

            <form @submit.prevent="handleSubmit" class="recipe-form">
                <div class="form-section">
                    <label class="section-label">Image of the dish</label>
                    <div class="image-upload-container">
                        <div v-if="form.image" class="image-preview">
                            <img :src="form.image" alt="Preview" class="preview-image">
                            <button :disabled="!isEditable" type="button" @click="removeImage" class="remove-image-btn">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M6 18L18 6M6 6L18 18" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                                </svg>
                            </button>
                        </div>
                        <div v-else class="upload-area" @click="triggerFileInput">
                            <input
                                ref="fileInput"
                                type="file"
                                accept="image/*"
                                @change="handleImageUpload"
                                class="file-input"
                                :readonly="!isEditable"
                            >
                            <svg width="48" height="48" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M14 2H6C4.89543 2 4 2.89543 4 4V20C4 21.1046 4.89543 22 6 22H18C19.1046 22 20 21.1046 20 20V8M14 2L20 8M14 2V8H20"
                                      stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                            <p>Click to download the image</p>
                        </div>
                    </div>
                </div>

                <div class="form-section">
                    <label for="name" class="form-label">Name of the dish</label>
                    <input
                        id="name"
                        v-model="form.name"
                        type="text"
                        placeholder="Enter the name of the dish"
                        class="common-input"
                        required
                        :readonly="!isEditable"
                    >
                </div>

                <div class="form-section">
                    <label for="cuisine" class="form-label">Cuisine</label>
                    <select v-if="isEditable"
                            id="cuisine"
                            v-model="form.cuisine_id"
                            class="common-input"
                            required
                    >
                        <option value="">Choose a cuisine</option>
                        <option
                            v-for="cuisine in cuisines"
                            :key="cuisine.id"
                            :value="cuisine.id"
                        >
                            {{ cuisine.label }}
                        </option>
                    </select>
                    <span v-else>{{ form.cuisine.label }}</span>
                </div>

                <div class="form-section">
                    <label for="description" class="form-label">Description</label>
                    <textarea
                        id="description"
                        v-model="form.description"
                        placeholder="Describe the cooking process..."
                        rows="5"
                        class="common-input"
                        required
                        :readonly="!isEditable"
                    ></textarea>
                </div>

                <div class="form-section">
                    <div class="section-header">
                        <label class="section-label">Ingredients</label>
                        <button
                            type="button"
                            @click="addIngredient"
                            class="add-button"
                            :disabled="!isEditable"
                        >
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M12 5V19M5 12H19" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                            </svg>
                            Add ingredient
                        </button>
                    </div>

                    <div class="ingredients-table">
                        <table class="editable-table">
                            <thead>
                            <tr>
                                <th>Name</th>
                                <th>Quantity</th>
                                <th>Unit</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="(ingredient, index) in form.ingredients" :key="ingredient.id">
                                <td>
                                    <input
                                        v-model="ingredient.name"
                                        placeholder="Ingredient name"
                                        class="common-input"
                                        :class="{ 'error': !ingredient.name && ingredient.touched }"
                                        @blur="ingredient.touched = true"
                                        :readonly="!isEditable"
                                    >
                                </td>
                                <td>
                                    <input
                                        v-model="ingredient.count"
                                        type="number"
                                        placeholder="0"
                                        min="0"
                                        step="0.1"
                                        class="common-input number-input"
                                        :class="{ 'error': (!ingredient.count && ingredient.count !== 0) && ingredient.touched }"
                                        @blur="ingredient.touched = true"
                                        :readonly="!isEditable"
                                    >
                                </td>
                                <td>
                                    <input
                                        v-model="ingredient.unit"
                                        class="common-input"
                                        :class="{ 'error': !ingredient.unit && ingredient.touched }"
                                        @blur="ingredient.touched = true"
                                        :readonly="!isEditable"
                                    >
                                </td>
                                <td>
                                    <div class="action-buttons">
                                        <button
                                            type="button"
                                            @click="removeIngredient(index)"
                                            class="action-btn delete-btn"
                                            :disabled="form.ingredients.length === 1 || !isEditable"
                                        >
                                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M4 7H20M10 11V17M14 11V17M5 7L6 19C6 19.5304 6.21071 20.0391 6.58579 20.4142C6.96086 20.7893 7.46957 21 8 21H16C16.5304 21 17.0391 20.7893 17.4142 20.4142C17.7893 20.0391 18 19.5304 18 19L19 7M9 7V4C9 3.73478 9.10536 3.48043 9.29289 3.29289C9.48043 3.10536 9.73478 3 10 3H14C14.2652 3 14.5196 3.10536 14.7071 3.29289C14.8946 3.48043 15 3.73478 15 4V7"
                                                      stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>

                            <tr v-if="form.ingredients.length === 0">
                                <td colspan="4" class="no-data">
                                    No ingredients. Click "Add Ingredient"
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="form-actions">
                    <button
                        type="button"
                        @click="handleCancel"
                        class="cancel-button"
                    >
                        Отмена
                    </button>
                    <button
                        type="submit"
                        :disabled="loading || !isFormValid || !isEditable"
                        class="common-button-primary"
                    >
                        <span v-if="loading" class="common-button-loading">
                            <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            Saving...
                        </span>
                        <span v-else>{{ isEditing ? 'Update' : 'Create' }} recipe</span>
                    </button>
                </div>
            </form>

            <div v-if="errorMessage" class="common-error-message">
                {{ errorMessage }}
            </div>
        </div>
    </div>
</template>

<script>
import requester from "../modules/requester";

export default {
    name: 'RecipeCard',
    data() {
        return {
            isEditable: true,
            loading: false,
            errorMessage: '',
            cuisines: [],
            form: {
                id: null,
                name: '',
                description: '',
                cuisine_id: '',
                image: null,
                ingredients: [
                    { id: null, name: '', count: '', unit: '', touched: false }
                ]
            }
        }
    },
    computed: {
        isEditing() {
            return this.$route.params.id && this.$route.params.id !== 'new';
        },
        isFormValid() {
            return this.form.name &&
                this.form.description &&
                this.form.cuisine_id &&
                this.form.ingredients.every(ing => ing.name && ing.count && ing.unit)
        },
    },
    methods: {
        triggerFileInput() {
            this.$refs.fileInput?.click()
        },
        handleImageUpload(event) {
            const file = event.target.files[0]
            if (file) {
                const reader = new FileReader()
                reader.onload = (e) => {
                    this.form.image = e.target.result;
                }
                reader.readAsDataURL(file)
            }
        },
        removeImage() {
            this.form.image = null
            if (this.$refs.fileInput) {
                this.$refs.fileInput.value = ''
            }
        },
        addIngredient() {
            this.form.ingredients.push({
                id: null,
                name: '',
                count: '',
                unit: '',
                touched: false
            })
        },
        removeIngredient(index) {
            if (this.form.ingredients.length > 1) {
                this.form.ingredients.splice(index, 1)
            }
        },
        async fetchCuisines() {
            requester.sendGet('/api/dimension/cuisine')
                .then(response => {
                    this.cuisines = response.data;
                })
            ;
        },
        async handleSubmit() {
            if (!this.isFormValid) return;
            this.loading = true;
            const submitData = {
                ...this.form,
                ingredients: this.form.ingredients.map(ing => ({
                    id: ing.id,
                    name: ing.name,
                    count: parseFloat(ing.count),
                    unit: ing.unit
                }))
            }
            await requester.sendPost('/api/recipe/save', submitData);
            this.loading = false;
        },
        handleCancel() {
            this.$router.push({name: 'RecipeList'});
        }
    },
    mounted() {
        this.fetchCuisines();
        if (this.isEditing) {
            requester.sendGet('/api/recipe/getCard/' + this.$route.params.id)
                .then(response => {
                    const data = response.data;
                    this.form = {
                        id: data.id,
                        name: data.name || '',
                        description: data.description || '',
                        cuisine_id: data.cuisine.id || '',
                        cuisine: data.cuisine || {
                            id: null,
                            label: null
                        },
                        image: data.image || null,
                        ingredients: data.ingredients.map(ing => ({
                            id: ing.id || null,
                            name: ing.name || '',
                            count: ing.count || '',
                            unit: ing.unit || '',
                            touched: false
                        }))
                    };
                    this.isEditable = data.isEditable;
                    this.$forceUpdate();
                })
            ;
        }
    }
}
</script>

<style scoped>
.recipe-form {
    display: flex;
    flex-direction: column;
    gap: 32px;
}

.form-section {
    display: flex;
    flex-direction: column;
    gap: 16px;
}

.section-label {
    font-size: 18px;
    font-weight: 600;
    color: #2d3748;
}

.form-label {
    font-weight: 600;
    color: #2d3748;
    font-size: 14px;
}

.image-upload-container {
    display: flex;
    flex-direction: column;
    gap: 16px;
}

.upload-area {
    border: 2px dashed #cbd5e0;
    border-radius: 8px;
    padding: 40px;
    text-align: center;
    cursor: pointer;
    transition: all 0.3s ease;
    color: #718096;
}

.upload-area:hover {
    border-color: #667eea;
    color: #667eea;
}

.file-input {
    display: none;
}

.image-preview {
    position: relative;
    display: inline-block;
}

.preview-image {
    width: 200px;
    height: 200px;
    object-fit: cover;
    border-radius: 8px;
    border: 2px solid #e2e8f0;
}

.remove-image-btn {
    position: absolute;
    top: -8px;
    right: -8px;
    background: #f56565;
    color: white;
    border: none;
    border-radius: 50%;
    width: 32px;
    height: 32px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: background 0.3s ease;
}

.remove-image-btn:hover {
    background: #e53e3e;
}

.section-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.add-button {
    background: #48bb78;
    color: white;
    border: none;
    padding: 8px 16px;
    border-radius: 6px;
    font-size: 14px;
    font-weight: 500;
    cursor: pointer;
    display: flex;
    align-items: center;
    gap: 8px;
    transition: background 0.3s ease;
}

.add-button:hover {
    background: #38a169;
}

.ingredients-table {
    overflow-x: auto;
}

.editable-table {
    width: 100%;
    border-collapse: collapse;
    background: white;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
}

.editable-table th {
    background: #f7fafc;
    padding: 12px 16px;
    text-align: left;
    font-weight: 600;
    color: #2d3748;
    border-bottom: 2px solid #e2e8f0;
    font-size: 14px;
}

.editable-table td {
    padding: 12px 16px;
    border-bottom: 1px solid #e2e8f0;
    vertical-align: top;
}

.number-input {
    text-align: right;
}

.action-buttons {
    display: flex;
    gap: 8px;
}

.action-btn {
    padding: 6px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    justify-content: center;
}

.delete-btn {
    background: #fed7d7;
    color: #c53030;
}

.delete-btn:hover:not(:disabled) {
    background: #feb2b2;
}

.delete-btn:disabled {
    opacity: 0.5;
    cursor: not-allowed;
}

.no-data {
    text-align: center;
    color: #718096;
    font-style: italic;
    padding: 40px !important;
}

.form-actions {
    display: flex;
    gap: 16px;
    justify-content: flex-end;
    margin-top: 32px;
}

.cancel-button {
    background: transparent;
    color: #4a5568;
    border: 2px solid #e2e8f0;
    padding: 12px 24px;
    border-radius: 8px;
    font-size: 16px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
}

.cancel-button:hover {
    border-color: #cbd5e0;
    background: #f7fafc;
}

@media (max-width: 768px) {
    .section-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 12px;
    }

    .form-actions {
        flex-direction: column;
    }

    .editable-table {
        font-size: 14px;
    }

    .editable-table th,
    .editable-table td {
        padding: 8px 12px;
    }
}
</style>
