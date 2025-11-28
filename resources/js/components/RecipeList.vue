<template>
    <div class="table-container">
        <div class="table-header">
            <h2 class="table-title">Recipes</h2>
            <div class="header-actions">
                <div class="search-box">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="#718096">
                        <path d="M15.5 14h-.79l-.28-.27C15.41 12.59 16 11.11 16 9.5 16 5.91 13.09 3 9.5 3S3 5.91 3 9.5 5.91 16 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"/>
                    </svg>
                    <input
                        v-model="searchQuery"
                        placeholder="Search..."
                        class="search-input"
                    >
                </div>
                <button v-if="isAuthenticated" :disabled="!isAuthenticated" class="add-btn" @click="handleAdd">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"/>
                    </svg>
                    Add recipe
                </button>
            </div>
        </div>

        <div class="table-wrapper">
            <table class="recipes-table">
                <thead>
                    <tr>
                        <th class="table-col">{{ isAuthenticated ? 'Edit' : 'View' }}</th>
                        <th class="table-col" @click="sortBy('name')">
                            Name
                            <span class="sort-icon" v-if="sortField === 'name'">
                                {{ sortDirection === 'asc' ? '↑' : '↓' }}
                            </span>
                        </th>
                        <th class="table-col" @click="sortBy('updated_at')">
                            Updated <br> date
                            <span class="sort-icon" v-if="sortField === 'updated_at'">
                                {{ sortDirection === 'asc' ? '↑' : '↓' }}
                            </span>
                        </th>
                        <th class="table-col">Cuisine</th>
                        <th class="ingredients-col">Ingredients</th>
                        <th class="table-col" v-if="isAuthenticated">Delete</th>
                    </tr>
                </thead>
                <tbody v-if="!fetchTable">
                    <tr v-for="recipe in recipes" :key="recipe.id" class="table-row">
                        <td class="table-col">
                            <button class="icon-btn edit-btn" @click="handleEdit(recipe.id)" :title="recipe.isEditable ? 'Edit' : 'View'">
                                <svg v-if="recipe.isEditable" width="18" height="18" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM20.71 7.04c.39-.39.39-1.02 0-1.41l-2.34-2.34c-.39-.39-1.02-.39-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z"/>
                                </svg>
                                <svg v-else width="18" height="18" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z"/>
                                </svg>
                            </button>
                        </td>

                        <td class="table-col">
                            <span class="recipe-name">{{ recipe.name }}</span>
                        </td>

                        <td class="table-col">
                            <span class="cuisine-tag">{{ recipe.updated_at }}</span>
                        </td>

                        <td class="table-col">
                            <span class="cuisine-tag">{{ recipe.cuisine }}</span>
                        </td>

                        <td class="ingredients-cell">
                            <div class="ingredients-list">
                                <span
                                    v-for="ingredient in recipe.ingredients.slice(0, 3)"
                                    :key="ingredient"
                                    class="ingredient-tag"
                                >
                                    {{ ingredient }}
                                </span>
                                <span v-if="recipe.ingredients.length > 3" class="ingredient-more">
                                    +{{ recipe.ingredients.length - 3 }} ещё
                                </span>
                            </div>
                        </td>

                        <!-- Delete Column -->
                        <td v-if="isAuthenticated && recipe.isDeletable" class="table-col">
                            <button :disabled="!recipe.isDeletable" class="icon-btn delete-btn" @click="handleDelete(recipe.id)" title="Удалить">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zM19 4h-3.5l-1-1h-5l-1 1H5v2h14V4z"/>
                                </svg>
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>

            <Spinner v-if="fetchTable"></Spinner>

            <div v-if="recipes.length === 0 && !fetchTable" class="empty-state">
                <svg width="64" height="64" viewBox="0 0 24 24" fill="#cbd5e0">
                    <path d="M8.1 13.34l2.83-2.83L3.91 3.5c-1.56 1.56-1.56 4.09 0 5.66l4.19 4.18zm6.78-1.81c1.53.71 3.68.21 5.27-1.38 1.91-1.91 2.28-4.65.81-6.12-1.46-1.46-4.2-1.1-6.12.81-1.59 1.59-2.09 3.74-1.38 5.27L3.7 19.87l1.41 1.41L12 14.41l6.88 6.88 1.41-1.41L13.41 13l1.47-1.47z"/>
                </svg>
                <p>{{ searchQuery ? 'Recipes not found' : 'No added recipes' }}</p>
            </div>
        </div>

        <div v-if="recipes.length > 0" class="pagination-container">
            <div class="pagination-info">
                Showed {{ startItem }}-{{ endItem }} from {{ totalItems }} records
            </div>

            <div class="pagination-controls">
                <button
                    class="pagination-btn"
                    :disabled="currentPage === 1"
                    @click="changePage(currentPage - 1)"
                >
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M15.41 7.41L14 6l-6 6 6 6 1.41-1.41L10.83 12z"/>
                    </svg>
                    Previous
                </button>

                <div class="page-numbers">
                    <button
                        v-for="page in visiblePages"
                        :key="page"
                        class="page-btn"
                        :class="{ active: page === currentPage }"
                        @click="changePage(page)"
                    >
                        {{ page }}
                    </button>
                    <span v-if="showEllipsis" class="page-ellipsis">...</span>
                </div>

                <button
                    class="pagination-btn"
                    :disabled="currentPage === totalPages"
                    @click="changePage(currentPage + 1)"
                >
                    Next
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M10 6L8.59 7.41 13.17 12l-4.58 4.59L10 18l6-6z"/>
                    </svg>
                </button>
            </div>

            <div class="page-size-selector">
                <label>Per page:</label>
                <select v-model="itemsPerPage" @change="resetToFirstPage" class="page-select">
                    <option value="5">5</option>
                    <option value="10">10</option>
                    <option value="20">20</option>
                    <option value="50">50</option>
                </select>
            </div>
        </div>
    </div>
</template>

<script>
import Spinner from "./Spinner.vue";
import requester from "../modules/requester";
import {mapGetters} from "vuex";

export default {
    name: 'RecipeList',
    components: { Spinner },
    data() {
        return {
            // Данные
            recipes: [
            ],

            // Пагинация
            currentPage: 1,
            itemsPerPage: 5,
            totalPages: 1,
            startItem: 1,
            endItem: 1,
            totalItems: 1,

            // Поиск и сортировка
            searchQuery: '',
            sortField: 'updated_at',
            sortDirection: 'desc',
            fetchTable: false,
        }
    },
    computed: {
        ...mapGetters('user', ['isAuthenticated']),

        visiblePages() {
            const pages = []
            const total = this.totalPages;
            let start = Math.max(1, this.currentPage - 2);
            let end = Math.min(total, start + 4);

            if (end - start < 4) {
                start = Math.max(1, end - 4);
            }

            for (let i = start; i <= end; i++) {
                pages.push(i);
            }

            return pages
        },

        // Показывать ли многоточие
        showEllipsis() {
            return this.totalPages > 5 && this.currentPage < this.totalPages - 2
        },
    },
    watch: {
        isAuthenticated: {
            immediate: false,
            handler(newVal) {
                this.fetchRecords();
            },
        },
        searchQuery: {
            immediate: false,
            handler(newVal, oldVal) {
                if (newVal !== oldVal) {
                    this.handleSearch();
                }
            },
        }
    },
    methods: {
        handleEdit(recipeId) {
            this.$router.push(`/recipe/rec/${recipeId}`);
        },

        handleDelete(recipeId) {
            if (confirm('Вы уверены, что хотите удалить этот рецепт?')) {
                requester.sendDelete('/api/recipe/delete', {
                    params: {
                        id: recipeId
                    }
                })
                    .then(response => {
                        this.recipes = this.recipes.filter(recipe => recipe.id !== recipeId)
                        // Если на текущей странице не осталось элементов, перейти на предыдущую
                        if (this.recipes.length === 0 && this.currentPage > 1) {
                            this.currentPage--;
                            this.fetchRecords();
                        }
                    })
            }
        },

        handleAdd() {
            this.$router.push('/recipe/rec/new');
        },

        // Пагинация
        changePage(page) {
            if (page >= 1 && page <= this.totalPages) {
                this.currentPage = page;
                this.fetchRecords();
            }
        },

        resetToFirstPage() {
            this.currentPage = 1;
            this.fetchRecords();
        },

        handleSearch() {
            this.resetToFirstPage();
        },

        sortBy(field) {
            if (this.sortField === field) {
                this.sortDirection = this.sortDirection === 'asc' ? 'desc' : 'asc';
            } else {
                this.sortField = field;
                this.sortDirection = 'asc';
            }
            this.resetToFirstPage()
        },

        fetchRecords() {
            this.fetchTable = true;

            requester.search('/api/recipe/getList', {
                params: {
                    page: this.currentPage,
                    size: this.itemsPerPage,
                    sortBy: this.sortField,
                    sortOrder: this.sortDirection,
                    searchQuery: this.searchQuery,
                }
            })
                .then(response => {
                    const meta = response.meta;
                    const data = response.data;

                    this.totalPages = meta.last_page;
                    this.currentPage = meta.current_page;
                    this.startItem = meta.from;
                    this.endItem = meta.to;
                    this.totalItems = meta.total;

                    this.recipes = [];

                    this.recipes = data.map(recipe => ({
                        id: recipe.id,
                        name: recipe.name,
                        cuisine: recipe.cuisine.label,
                        ingredients: recipe.ingredients.map(ing => ing.name),
                        isDeletable: recipe.isDeletable,
                        isEditable: recipe.isEditable,
                        updated_at: recipe.updated_at
                    }))

                    this.$forceUpdate();
                    this.fetchTable = false;
                })
            ;
        }
    },
    mounted() {
        this.fetchRecords();
    }
}
</script>

<style scoped>
.table-container {
    width: 90%;
    background: #ffffff;
    border-radius: 8px;
    border: 1px solid #e2e8f0;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    overflow: hidden;

    margin: 1rem;
}

.table-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 1.5rem 2rem;
    border-bottom: 1px solid #e2e8f0;
    background: #f7fafc;
}

.table-title {
    font-size: 1.5rem;
    font-weight: 600;
    color: #2d3748;
    margin: 0;
}

.add-btn {
    background: #667eea;
    color: white;
    border: none;
    padding: 0.75rem 1.5rem;
    border-radius: 6px;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.2s ease;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.add-btn:hover {
    background: #5a6fd8;
    transform: translateY(-1px);
}

.table-wrapper {
    overflow-x: auto;
}

.recipes-table {
    width: 100%;
    border-collapse: collapse;
}

.recipes-table th {
    background: #f7fafc;
    padding: 1rem 1.5rem;
    text-align: left;
    font-weight: 600;
    color: #4a5568;
    border-bottom: 1px solid #e2e8f0;
    font-size: 0.875rem;
    text-transform: uppercase;
    letter-spacing: 0.05em;
}

.recipes-table td {
    padding: 1rem 1.5rem;
    border-bottom: 1px solid #e2e8f0;
    vertical-align: center;
}

.table-row:hover {
    background: #f7fafc;
}

.icon-btn {
    background: none;
    border: none;
    padding: 0.5rem;
    border-radius: 6px;
    cursor: pointer;
    transition: all 0.2s ease;
    display: inline-flex;
    align-items: center;
    justify-content: center;
}

.edit-btn {
    color: #667eea;
}

.edit-btn:hover {
    background: rgba(102, 126, 234, 0.1);
    transform: scale(1.1);
}

.delete-btn {
    color: #e53e3e;
}

.delete-btn:hover {
    background: rgba(229, 62, 62, 0.1);
    transform: scale(1.1);
}

/* Content Cells */
.recipe-name {
    font-weight: 500;
    color: #2d3748;
}

.cuisine-tag {
    background: rgba(102, 126, 234, 0.1);
    color: #667eea;
    padding: 0.25rem 0.75rem;
    border-radius: 20px;
    font-size: 0.875rem;
    font-weight: 500;
}

.ingredients-list {
    display: flex;
    flex-wrap: wrap;
    gap: 0.5rem;
}

.ingredient-tag {
    background: #edf2f7;
    color: #4a5568;
    padding: 0.25rem 0.5rem;
    border-radius: 6px;
    font-size: 0.75rem;
    border: 1px solid #e2e8f0;
}

/* Empty State */
.empty-state {
    text-align: center;
    padding: 4rem 2rem;
    color: #718096;
}

.empty-state p {
    margin: 1rem 0 2rem;
    font-size: 1.125rem;
}

/* Responsive */
@media (max-width: 768px) {
    .table-header {
        flex-direction: column;
        gap: 1rem;
        align-items: stretch;
    }

    .add-btn {
        justify-content: center;
    }

    .recipes-table {
        font-size: 0.875rem;
    }

    .recipes-table th,
    .recipes-table td {
        padding: 0.75rem 1rem;
    }
}

.table-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 1.5rem 2rem;
    border-bottom: 1px solid #e2e8f0;
    background: #f7fafc;
}

.header-actions {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.search-box {
    display: flex;
    align-items: center;
    background: white;
    border: 1px solid #e2e8f0;
    border-radius: 6px;
    padding: 0.5rem 0.75rem;
    gap: 0.5rem;
}

.search-input {
    border: none;
    outline: none;
    background: none;
    width: 200px;
    color: #4a5568;
}

.search-input::placeholder {
    color: #a0aec0;
}

/* Стили для сортировки */
th {
    cursor: pointer;
    user-select: none;
    position: relative;
}

.sort-icon {
    margin-left: 0.5rem;
    font-weight: bold;
    color: #667eea;
}

/* Пагинация */
.pagination-container {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 1.5rem 2rem;
    border-top: 1px solid #e2e8f0;
    background: #f7fafc;
    flex-wrap: wrap;
    gap: 1rem;
}

.pagination-info {
    color: #718096;
    font-size: 0.875rem;
}

.pagination-controls {
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.pagination-btn {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    background: white;
    border: 1px solid #e2e8f0;
    padding: 0.5rem 1rem;
    border-radius: 6px;
    cursor: pointer;
    transition: all 0.2s ease;
    color: #4a5568;
}

.pagination-btn:hover:not(:disabled) {
    background: #667eea;
    color: white;
    border-color: #667eea;
}

.pagination-btn:disabled {
    opacity: 0.5;
    cursor: not-allowed;
}

.page-numbers {
    display: flex;
    align-items: center;
    gap: 0.25rem;
}

.page-btn {
    min-width: 2.5rem;
    height: 2.5rem;
    display: flex;
    align-items: center;
    justify-content: center;
    background: white;
    border: 1px solid #e2e8f0;
    border-radius: 6px;
    cursor: pointer;
    transition: all 0.2s ease;
    color: #4a5568;
}

.page-btn:hover {
    background: #edf2f7;
}

.page-btn.active {
    background: #667eea;
    color: white;
    border-color: #667eea;
}

.page-ellipsis {
    padding: 0 0.5rem;
    color: #a0aec0;
}

.page-size-selector {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    color: #718096;
    font-size: 0.875rem;
}

.page-select {
    border: 1px solid #e2e8f0;
    border-radius: 6px;
    padding: 0.25rem 0.5rem;
    background: white;
    color: #4a5568;
}

/* Адаптивность */
@media (max-width: 768px) {
    .table-header {
        flex-direction: column;
        gap: 1rem;
        align-items: stretch;
    }

    .header-actions {
        flex-direction: column;
    }

    .search-box {
        width: 100%;
    }

    .search-input {
        width: 100%;
    }

    .pagination-container {
        flex-direction: column;
        text-align: center;
    }

    .pagination-controls {
        order: -1;
    }
}
</style>
