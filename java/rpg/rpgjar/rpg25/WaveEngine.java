import java.io.IOException;
import java.util.HashMap;

import javax.sound.sampled.AudioFormat;
import javax.sound.sampled.AudioInputStream;
import javax.sound.sampled.AudioSystem;
import javax.sound.sampled.Clip;
import javax.sound.sampled.DataLine;
import javax.sound.sampled.LineEvent;
import javax.sound.sampled.LineListener;
import javax.sound.sampled.LineUnavailableException;
import javax.sound.sampled.UnsupportedAudioFileException;

/*
 * Created on 2006/11/05
 */

public class WaveEngine implements LineListener {
    // �o�^�ł���WAVE�t�@�C���̍ő吔
    private int maxClips;
    // WAVE�t�@�C���f�[�^�i���O->�f�[�^�{�́j
    private HashMap clipMap;
    // �o�^���ꂽWAVE�t�@�C����
    private int counter = 0;

    /**
     * �R���X�g���N�^
     */
    public WaveEngine() {
        this(256);
    }

    /**
     * �R���X�g���N�^
     * 
     * @param maxClips
     *            �o�^�ł���WAVE�t�@�C���̍ő吔
     */
    public WaveEngine(int maxClips) {
        this.maxClips = maxClips;
        clipMap = new HashMap(maxClips);
    }

    /**
     * WAVE�t�@�C�������[�h
     * @param name �o�^��
     * @param filename �t�@�C����
     */
    public void load(String name, String filename) {
        if (counter == maxClips) {
            System.out.println("�G���[: ����ȏ�o�^�ł��܂���");
            return;
        }

        try {
            // �I�[�f�B�I�X�g���[�����J��
            AudioInputStream stream = AudioSystem
                    .getAudioInputStream(getClass().getResource(filename));

            // �I�[�f�B�I�`�����擾
            AudioFormat format = stream.getFormat();
            // ULAW/ALAW�`���̏ꍇ��PCM�`���ɕύX
            if ((format.getEncoding() == AudioFormat.Encoding.ULAW)
                    || (format.getEncoding() == AudioFormat.Encoding.ALAW)) {
                AudioFormat newFormat = new AudioFormat(
                        AudioFormat.Encoding.PCM_SIGNED,
                        format.getSampleRate(),
                        format.getSampleSizeInBits() * 2, format.getChannels(),
                        format.getFrameSize() * 2, format.getFrameRate(), true);
                stream = AudioSystem.getAudioInputStream(newFormat, stream);
                format = newFormat;
            }

            // ���C�������擾
            DataLine.Info info = new DataLine.Info(Clip.class, format);
            // �T�|�[�g����Ă�`�����`�F�b�N
            if (!AudioSystem.isLineSupported(info)) {
                System.out.println("�G���[: " + filename + "�̓T�|�[�g����Ă��Ȃ��`���ł�");
                System.exit(0);
            }

            // ��̃N���b�v���쐬
            Clip clip = (Clip) AudioSystem.getLine(info);
            // �N���b�v�̃C�x���g���Ď�
            clip.addLineListener(this);
            // �I�[�f�B�I�X�g���[�����N���b�v�Ƃ��ĊJ��
            clip.open(stream);
            // �N���b�v��o�^
            clipMap.put(name, clip);
            // �X�g���[�������
            stream.close();
        } catch (UnsupportedAudioFileException e) {
            e.printStackTrace();
        } catch (IOException e) {
            e.printStackTrace();
        } catch (LineUnavailableException e) {
            e.printStackTrace();
        }
    }

    /**
     * �Đ�
     * @param name �o�^��
     */
    public void play(String name) {
        // ���O�ɑΉ�����N���b�v���擾
        Clip clip = (Clip)clipMap.get(name);
        if (clip != null) {
            clip.start();
        }
    }

    public void update(LineEvent event) {
        // �X�g�b�v���Ō�܂ōĐ����ꂽ�ꍇ
        if (event.getType() == LineEvent.Type.STOP) {
            Clip clip = (Clip) event.getSource();
            clip.stop();
            clip.setFramePosition(0); // �Đ��ʒu���ŏ��ɖ߂�
        }
    }
}
