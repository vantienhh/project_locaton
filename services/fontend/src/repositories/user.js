import BaseRepository from './base'

class UserRepository extends BaseRepository {
  async login(credential, query = {}, headers = {}) {
    let url = 'api/login'
    try {
      let response = await this.httpClient.post(url, credential, {params: query, headers: headers})
      return this.success(response.data)
    } catch (e) {
      return this.handlerHttpError(e)
    }
  }

  async profile(query = {}, headers = {}) {
    let url = '/api/profile'
    try {
      let response = await this.httpClient.get(url, { params: query, headers: headers })
      return this.success(response.data)
    } catch(e) {
      return this.handlerHttpError(e)
    }
  }
}

export default UserRepository

