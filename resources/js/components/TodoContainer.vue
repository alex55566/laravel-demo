<template>
    <div class="storage-wrapper">
        <button
            v-for="btn in storeBtns"
            :key="btn"
            :class="[{ active: currentStorage === btn }]"
            @click="onChangeStorage(btn)"
        >
            {{ getBtnText(btn) }}
        </button>
    </div>
    <h1>ToDo List</h1>
    <form @submit="onSubmit($event)">
        <input v-model="todo" />
        <button>Add</button>
    </form>
    <div>
        <h3>Todos</h3>
        <ul class="wrapper-todos">
            <li
                class="wrapper-todo"
                v-for="todo in todos"
                :key="todo.id"
                :class="{ completed: todo.completed }"
            >
                <input
                    type="checkbox"
                    :checked="todo.completed"
                    @click="toogleTodo(todo)"
                />
                <div class="todo-title">{{ todo.title }}</div>
                <button @click="deleteTodo(todo.id)">Delete</button>
            </li>
        </ul>
    </div>
</template>

<script setup lang="ts">
import axios from "axios";
import { openDB } from "idb";
import { nanoid } from "nanoid";
import { Ref, getCurrentInstance, onMounted, ref, toRaw } from "vue";

interface ITodo {
    id: string;
    title: string;
    completed: boolean;
}

enum StorageType {
    SESSION = "sessionStorage",
    LOCAL = "localStorage",
    COOKIES = "cookies",
    DATABASE = "database",
    INDEXEDDB = "indexedDB",
}

const storeBtns = [
    StorageType.LOCAL,
    StorageType.SESSION,
    StorageType.COOKIES,
    StorageType.DATABASE,
    StorageType.INDEXEDDB,
];

const todo = ref("");

const todos: Ref<ITodo[]> = ref([]);

const instance = getCurrentInstance();
const $cookies = instance?.appContext.config.globalProperties.$cookies;

const currentStorage: Ref<StorageType> = ref(StorageType.LOCAL);

onMounted(() => {
    getStorageTodos();
});

// Создаем экземпляр базы данных
const dbPromise = openDB("todo-database", 2, {
    upgrade(db) {
        if (!db.objectStoreNames.contains("todos")) {
            db.createObjectStore("todos", { keyPath: "id" });
        }
    },
});

const setIndexedDBTodos = async (todos: ITodo[]) => {
    const db = await dbPromise;
    const tx = db.transaction("todos", "readwrite");
    await tx.objectStore("todos").clear();
    for (const todo of todos) {
        await tx.objectStore("todos").put(todo);
    }
    await tx.done;
};

const getIndexedDBTodos = async (): Promise<ITodo[]> => {
    const db = await dbPromise;
    return await db.getAll("todos");
};

const onSubmit = (e: Event) => {
    e.preventDefault();
    addTodo();
    todo.value = "";
};

const addTodo = async () => {
    const newTodo = {
        title: todo.value,
        completed: false,
    };

    if (currentStorage.value === StorageType.DATABASE) {
        const { data } = await axios.post("/api/todos", newTodo);
        todos.value.push(data);
    } else {
        todos.value.push({ ...newTodo, id: nanoid() });
        setStorageTodos();
    }
};

const deleteTodo = async (id: string) => {
    todos.value = todos.value.filter((todo) => todo.id !== id);
    if (currentStorage.value === StorageType.DATABASE) {
        await axios.delete(`/api/todos/${id}`);
    } else {
        setStorageTodos();
    }
};

const toogleTodo = async (todo: ITodo) => {
    todo.completed = !todo.completed;
    if (currentStorage.value === StorageType.DATABASE) {
        await axios.put(`/api/todos/${todo.id}`, todo);
    } else {
        setStorageTodos();
    }
};

const setStorageTodos = async () => {
    const rawTodos = toRaw(todos.value); // Убираем реактивность
    switch (currentStorage.value) {
        case StorageType.SESSION:
            sessionStorage.setItem("todos", JSON.stringify(todos.value));
            break;
        case StorageType.LOCAL:
            localStorage.setItem("todos", JSON.stringify(todos.value));
            break;
        case StorageType.COOKIES:
            if ($cookies) $cookies.set("todos", rawTodos);
            break;
        case StorageType.INDEXEDDB:
            await setIndexedDBTodos(rawTodos);
    }
};

const getStorageTodos = async () => {
    switch (currentStorage.value) {
        case StorageType.SESSION:
            todos.value = JSON.parse(sessionStorage.getItem("todos") || "[]");
            break;
        case StorageType.LOCAL:
            todos.value = JSON.parse(localStorage.getItem("todos") || "[]");
            break;
        case StorageType.COOKIES:
            if ($cookies) {
                todos.value = $cookies.get("todos") || [];
            }
            break;
        case StorageType.DATABASE:
            const { data } = await axios.get("/api/todos");
            todos.value = data;
            break;
        case StorageType.INDEXEDDB:
            todos.value = await getIndexedDBTodos();
            break;
    }
};

const onChangeStorage = async (type: StorageType) => {
    currentStorage.value = type;
    await getStorageTodos();
};

const getBtnText = (type: StorageType) => {
    switch (type) {
        case StorageType.SESSION:
            return "Session Storage";
        case StorageType.LOCAL:
            return "Local Storage";
        case StorageType.COOKIES:
            return "Cookies";
        case StorageType.DATABASE:
            return "DataBase";
        case StorageType.INDEXEDDB:
            return "IndexedDB";
    }
};
</script>

<style lang="scss" scoped>
$colorDenim: #1574bc;

.wrapper-todos {
    gap: 10px;
}
.wrapper-todo,
.storage-wrapper,
form {
    gap: 10px;
}
button {
    padding: 5px;
    border-radius: 10px;
    background-color: $colorDenim;
    color: white;
    &.active {
        background-color: #104a8d;
        transform: scale(0.95);
    }

    &:hover {
        background-color: solid($colorDenim, 10%);
    }

    &:focus {
        outline: 2px solid solid($colorDenim, 20%);
    }
}
.completed {
    .todo-title {
        text-decoration: line-through;
        color: gray;
    }
}
</style>
