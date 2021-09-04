import request from '../utils/request'

export function getAccountInfo(data) {
  return request({
    url: 'player_accountinfo',
    method: 'post',
    data
  })
}
export function getGameHistory(data) {
  return request({
    url: 'player_gamehistory',
    method: 'post',
    data
  })
}
