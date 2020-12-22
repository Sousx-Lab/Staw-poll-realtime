import {MERCURE_URL, VOTE_URL} from './config'
import {poll} from '../entity/poll'


export function mercureSubscriber(pollId, callback){
  const url = new URL(MERCURE_URL);
    url.searchParams.append('topic', VOTE_URL + `${pollId}`);
    const eventSouce = new EventSource(url);
      eventSouce.onmessage = ({ data }) => {
        console.log(data)
        Object.assign(poll, JSON.parse(data))
        callback(poll)
      }
}