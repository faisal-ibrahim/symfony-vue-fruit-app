export const httpWrapper = {
  get: request('GET'),
  post: request('POST'),
  put: request('PUT'),
  delete: request('DELETE')
}

function request(method: string) {
  return (url: string, body?: any) => {
    const requestOptions = {
      method,
      body
    }
    if (body) {
      requestOptions.body = JSON.stringify(body)
    }
    return fetch(url, requestOptions).then(handleResponse)
  }
}

function handleResponse(response: any) {
  return response.text().then((jsonString: string) => {
    const data = jsonString && JSON.parse(jsonString)
    if (!response.ok) {
      const error = data || { message: response.statusText }
      return Promise.reject(error)
    }
    return data
  })
}
