class TokenRepository {
  static setTokenToStorage (token) {
    window.$cookies.set('token', `${token.token_type} ${token.access_token}`)
  }

  static getTokenFromStorate () {
    return window.$cookies.get('token')
  }

  static removeTokenFromStorage () {
    window.$cookies.remove('token')
  }
}

export default TokenRepository
