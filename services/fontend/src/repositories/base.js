import router from '@/router'

class BaseRepository {
  constructor(httpClient) {
    this.httpClient = httpClient
  }

  handlerHttpError(e) {
    if (e.response && e.response.data) {
      let data    = {...e.response.data}
      data.status = data.status || e.response.status
      data.code   = data.code || e.response.status
      return this.error(data)
    } else {
      throw e
    }
  }

  success(data) {
    return {'success': true, response: data}
  }

  error(error) {
    if (error.code === 404) {
      router.push({name: 'notfound'})
    } else {
      return {'success': false, response: error}
    }
  }
}

export default BaseRepository
