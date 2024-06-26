// File generated by FlutterFire CLI.
// ignore_for_file: type=lint
import 'package:firebase_core/firebase_core.dart' show FirebaseOptions;
import 'package:flutter/foundation.dart'
    show defaultTargetPlatform, kIsWeb, TargetPlatform;

/// Default [FirebaseOptions] for use with your Firebase apps.
///
/// Example:
/// ```dart
/// import 'firebase_options.dart';
/// // ...
/// await Firebase.initializeApp(
///   options: DefaultFirebaseOptions.currentPlatform,
/// );
/// ```
class DefaultFirebaseOptions {
  static FirebaseOptions get currentPlatform {
    if (kIsWeb) {
      return web;
    }
    switch (defaultTargetPlatform) {
      case TargetPlatform.android:
        return android;
      case TargetPlatform.iOS:
        return ios;
      case TargetPlatform.macOS:
        return macos;
      case TargetPlatform.windows:
        return windows;
      case TargetPlatform.linux:
        throw UnsupportedError(
          'DefaultFirebaseOptions have not been configured for linux - '
          'you can reconfigure this by running the FlutterFire CLI again.',
        );
      default:
        throw UnsupportedError(
          'DefaultFirebaseOptions are not supported for this platform.',
        );
    }
  }

  static const FirebaseOptions web = FirebaseOptions(
    apiKey: 'AIzaSyDKePLXTkuLa4rg0w_4OHdaaKklCmSNu3w',
    appId: '1:99632716211:web:82dcc1173feec92b3153c6',
    messagingSenderId: '99632716211',
    projectId: 'tora-6cf40',
    authDomain: 'tora-6cf40.firebaseapp.com',
    storageBucket: 'tora-6cf40.appspot.com',
  );

  static const FirebaseOptions android = FirebaseOptions(
    apiKey: 'AIzaSyC95lSfjQBqLVBQ9IRSSx8pmnnvHsCLr7c',
    appId: '1:99632716211:android:dcb537dd5782a1bb3153c6',
    messagingSenderId: '99632716211',
    projectId: 'tora-6cf40',
    storageBucket: 'tora-6cf40.appspot.com',
  );

  static const FirebaseOptions ios = FirebaseOptions(
    apiKey: 'AIzaSyCdILpX6TaBAVidbDoO26y57V1ae-40uFI',
    appId: '1:99632716211:ios:acd5e90a9b3427e73153c6',
    messagingSenderId: '99632716211',
    projectId: 'tora-6cf40',
    storageBucket: 'tora-6cf40.appspot.com',
    iosBundleId: 'com.example.toraApp',
  );

  static const FirebaseOptions macos = FirebaseOptions(
    apiKey: 'AIzaSyCdILpX6TaBAVidbDoO26y57V1ae-40uFI',
    appId: '1:99632716211:ios:acd5e90a9b3427e73153c6',
    messagingSenderId: '99632716211',
    projectId: 'tora-6cf40',
    storageBucket: 'tora-6cf40.appspot.com',
    iosBundleId: 'com.example.toraApp',
  );

  static const FirebaseOptions windows = FirebaseOptions(
    apiKey: 'AIzaSyDKePLXTkuLa4rg0w_4OHdaaKklCmSNu3w',
    appId: '1:99632716211:web:5c2789ef2557b6353153c6',
    messagingSenderId: '99632716211',
    projectId: 'tora-6cf40',
    authDomain: 'tora-6cf40.firebaseapp.com',
    storageBucket: 'tora-6cf40.appspot.com',
  );

}