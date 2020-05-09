import BaseRepository from './base'

class DistrictRepository extends BaseRepository {
  async getDistricts(query = {}, headers = {}) {
    try {
      let url      = 'api/get_districts'
      let response = await this.httpClient.get(url, {params: query, headers: headers})
      return this.success(response.data)
    } catch (e) {
      return this.handlerHttpError(e)
    }
  }

  async districtPopulation(query = {}, headers = {}) {
    try {
      let url      = 'api/district_population'
      let response = await this.httpClient.get(url, {params: query, headers: headers})
      return this.success(response.data)
    } catch (e) {
      return this.handlerHttpError(e)
    }
  }

}

export default DistrictRepository

