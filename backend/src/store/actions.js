import axiosClient from "../axios";

export function getCurrentUser({commit}, data) {
  return axiosClient.get('/user', data)
    .then(({data}) => {
      commit('setUser', data);
      return data;
    })
}
export function login({commit}, data) {
  return axiosClient.post('/login', data)
    .then(({data}) => {
      commit('setUser', data.user);
      commit('setToken', data.token)
      return data;
    })
}
export function logout({commit}) {
  return axiosClient.post('/logout')
    .then((response) => {
      commit('setToken', null)

      return response;
    })
}

export function getProducts({commit, state}, {url = null, search = '', per_page, sort_field, sort_direction} = {}) {
  commit('setProducts', [true])
  url = url || '/products'
  const params = {
    per_page: state.products.limit,
  }
  return axiosClient.get(url, {
    params: {
      ...params,
      search, per_page, sort_field, sort_direction
    }
  })
    .then((response) => {
      commit('setProducts', [false, response.data])
    })
    .catch(() => {
      commit('setProducts', [false])
    })
}

export function getProduct({commit}, id) {
  return axiosClient.get(`/products/${id}`)
}

export function createProduct({commit}, product) {
  const form = new FormData();
  
  form.append('title', product.title);
  form.append('description', product.description || '');
  form.append('published', product.published ? 1 : 0);
  form.append('quantity', product.quantity || 0);
  form.append('price', product.price);

  if (Array.isArray(product.categories)) {
    product.categories.forEach(category => {
      form.append('categories[]', category); 
    });
  }

  if (product.images && product.images.length) {
    product.images.forEach(image => {
      if (image instanceof File) {
        form.append('images[]', image);
      }
    });
  }

  // Gửi dữ liệu đến API Laravel
  return axiosClient.post('/products', form);
}

export function updateProduct({commit}, product) {
  const form = new FormData();
  
  form.append('id', product.id);
  form.append('title', product.title);
  
  if (product.images && product.images.length) {
    product.images.forEach(image => {
      if (image instanceof File) {
        form.append(`images[${image.id}]`, image);  
      }
    });
  }

  if (product.deleted_images && product.deleted_images.length) {
    product.deleted_images.forEach(deletedImageId => {
      form.append('deleted_images[]', deletedImageId);  
    });
  }

  for (let id in product.image_positions) {
    form.append(`image_positions[${id}]`, product.image_positions[id]);
  }

  return axiosClient.post(`/products/${product.id}`, form);
}

export function deleteProduct({commit}, id) {
  return axiosClient.delete(`/products/${id}`)
}

export function getUsers({commit, state}, {url = null, search = '', per_page, sort_field, sort_direction} = {}) {
  commit('setUsers', [true])
  url = url || '/users'
  const params = {
    per_page: state.users.limit,
  }
  return axiosClient.get(url, {
    params: {
      ...params,
      search, per_page, sort_field, sort_direction
    }
  })
    .then((response) => {
      commit('setUsers', [false, response.data])
    })
    .catch(() => {
      commit('setUsers', [false])
    })
}

export function createUser({commit}, user) {
  return axiosClient.post('/users', user)
}

export function updateUser({commit}, user) {
  return axiosClient.put(`/users/${user.id}`, user)
}

export function getCustomers({commit, state}, {url = null, search = '', per_page, sort_field, sort_direction} = {}) {
  commit('setCustomers', [true])
  url = url || '/customers'
  const params = {
    per_page: state.customers.limit,
  }
  return axiosClient.get(url, {
    params: {
      ...params,
      search, per_page, sort_field, sort_direction
    }
  })
    .then((response) => {
      commit('setCustomers', [false, response.data])
    })
    .catch(() => {
      commit('setCustomers', [false])
    })
}

export function getCustomer({commit}, id) {
  return axiosClient.get(`/customers/${id}`)
}

export function createCustomer({commit}, customer) {
  return axiosClient.post('/customers', customer)
}

export function updateCustomer({commit}, customer) {
  return axiosClient.put(`/customers/${customer.id}`, customer)
}

export function deleteCustomer({commit}, customer) {
  return axiosClient.delete(`/customers/${customer.id}`)
}
export function deleteUser({commit}, user) {
  return axiosClient.delete(`/users/${user.id}`)
}

export function getCategories({commit, state}, {sort_field, sort_direction} = {}) {
  commit('setCategories', [true])
  return axiosClient.get('/categories', {
    params: {
      sort_field, sort_direction
    }
  })
    .then((response) => {
      commit('setCategories', [false, response.data])
    })
    .catch(() => {
      commit('setCategories', [false])
    })
}

export function createCategory({commit}, category) {
  return axiosClient.post('/categories', category)
}

export function updateCategory({commit}, category) {
  return axiosClient.put(`/categories/${category.id}`, category)
}

