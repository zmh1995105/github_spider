import React, {Component} from 'react'
import {Table, Button, Notice, Message} from 'bougie-design'
import axios from 'axios'
import {Link} from 'react-router-dom'

export default class ContainerList extends Component {
  state = {
    tableColumns: [{
      name: 'Names',
      dataIndex: "Names"
    }, {
      name: 'Image',
      dataIndex: "Image"
    }, {
      name: 'Command',
      dataIndex: "Command"
    }, {
      name: 'State',
      dataIndex: "State"
    }, {
      name: 'Status',
      dataIndex: "Status"
    }, {
      name: 'Action',
      render: ({State, Id}) => {
        const isRunning = State !== 'exited'
        return (
          <>
            <Button
              icon={isRunning ? 'square' : 'play'}
              onClick={this.startContainer.bind(this, Id, isRunning)}
              type={isRunning ? 'success' : 'primary'}>
              {isRunning ? 'stop' : 'start'}
            </Button>
            <span className='b-s' />
            <Link to={`/shell/${Id}`}>
              <Button
                type='success'>Login</Button>
            </Link>
            <span className='b-s' />
            <Button
              onClick={this.removeContainer.bind(this, Id)}
              icon='trash'
              type='error'>Delete</Button>
          </>
        )
      }
    }],
    tableData: []
  }
  async startContainer(id, isRunning) {
    if (isRunning) {
      await axios.get(`/apinode/container/stopcontainer/${id}`)
      Notice.success({
        message: `Stop ${id} success.`
      })
    } else {
      await axios.get(`/apinode/container/startcontainer/${id}`)
      Notice.success({
        message: `Start ${id} success.`
      })
    }
    this.getTableData()
  }
  removeContainer(id) {
    Message.confirm({
      message: `Are you sure delete ${id} ?`
    }).then(async() => {
      await axios.get(`/apinode/container/removecontainer/${id}`)
      await this.getTableData()
      Notice.success({
        message: `Delete ${id} success.`
      })
    }).catch(() => {})
  }
  async getTableData() {
    const {data: tableData} = await axios.get('/apinode/container/listcontainers')
    this.setState({tableData})
  }
  componentDidMount() {
    this.getTableData()
  }
  render() {
    const {tableColumns, tableData} = this.state
    return (
      <Table columns={tableColumns} data={tableData} />
    )
  }
}
