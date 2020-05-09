import BaseRepository from './base'

class ProvinceRepository extends BaseRepository {
  async getProvinces(query = {}, headers = {}) {
    try {
      let url      = 'api/get_provinces'
      let response = await this.httpClient.get(url, {params: query, headers: headers})
      return this.success(response.data)
    } catch (e) {
      return this.handlerHttpError(e)
    }
  }

  async provincePopulation(query = {}, headers = {}) {
    try {
      let url      = 'api/province_population'
      let response = await this.httpClient.get(url, {params: query, headers: headers})
      return this.success(response.data)
    } catch (e) {
      return this.handlerHttpError(e)
    }
  }

}

export default ProvinceRepository

