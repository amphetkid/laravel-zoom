# A Zoom API Package for Laravel

## Installation

-  Update your composer.json file and composer update

```shell
{
    "require": {
        "muratsaglik/laravel-zoom": "dev-master"
    }
}
```

## Configuration file

```shell
php artisan vendor:publish --provider="Muratsaglik\Zoom\ZoomServiceProvider"
```
## Usage
> User List
```shell
$zoom = new \Muratsaglik\Zoom\User();
$users = $zoom->listUsers();
```
> Delete User
```shell
$zoom = new \Muratsaglik\Zoom\User();
$delete = $zoom->deleteAUser($user_id);
```
> Create Meeting
```shell
$zoom = new \Muratsaglik\Zoom\Meeting();

$array = [
    'userId' => $request->host,
    'meetingTopic' => $request->title,
    'agenda' => $request->description,
    'start_date' => $request->date,
    'start_time' => $request->time,
    'timezone' => $request->timezone,
    'password' => $request->password,
    'duration' => $request->duration,
    'join_before_host' => $request->join_before_host,
    'option_host_video' => $request->option_host_video,
    'option_participants_video' => $request->option_participants_video,
    'option_mute_participants' => $request->option_mute_participants,
    'option_enforce_login' => $request->option_enforce_login,
    'option_auto_recording' => $request->option_auto_recording,
];

$create = $zoom->createAMeeting($array);
```


## License

[![License](http://img.shields.io/:license-mit-blue.svg?style=flat-square)](http://badges.mit-license.org)

- **[MIT license](http://opensource.org/licenses/mit-license.php)**
